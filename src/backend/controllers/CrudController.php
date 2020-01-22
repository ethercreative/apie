<?php

namespace ethercreative\apie\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\caching\DbDependency;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class CrudController extends Controller
{
    public
        $modelClass,
        $searchClass,
        $enableCache = true,
        $parent_id,
        $viewPath = '@apie/backend/views/crud',
        $views = [],
        $defaultOrder,
        $columns = [
            'id',
            'created_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        $exportColumns = [];

    private $_key;

    public function actionIndex($parentRelation = null)
    {
        if ($this->searchClass)
        {
            $get = array_merge(Yii::$app->request->get(), ['parentRelation' => $parentRelation]);

            $searchModel = new $this->searchClass;
            $dataProvider = $searchModel->search($get);
        }
        else
        {
            $searchModel = null;
            $dataProvider = new ActiveDataProvider([
                'query' => ($this->modelClass)::find(),
            ]);
        }

        if ($this->defaultOrder)
            $dataProvider->sort->defaultOrder = $this->defaultOrder;

        $tableName = (string) preg_replace('/([^\w\d\-\_])/', '', ($this->modelClass)::tableName());

        if ($tableName[0] !== '"')
            $tableName = '"' . Yii::$app->db->tablePrefix . $tableName . '"';

        if ($this->enableCache)
        {
            $dependency = new DbDependency;
            $dependency->sql = 'select extract(epoch from max("updated_at")) + count(id) as "updated_at" from ' . $tableName;

            Yii::$app->db->cache(function ($db) use ($dataProvider)
            {
                 $dataProvider->prepare();
            }, 3600, $dependency);
        }

        if ($defaults = Yii::$app->request->get('defaults', []))
            $defaults['defaults'] = $defaults;

        $defaults['parentRelation'] = $parentRelation;

        return $this->render($this->getCustomViewPath('index'), [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'columns' => $this->getColumns($searchModel),
            'exportColumns' => $this->getColumns($searchModel, $this->exportColumns),
            'defaults' => $defaults,
        ]);
    }

    public function actionCreate(array $defaults = null, $parentRelation = null)
    {
        $model = new $this->modelClass;

        if ($defaults)
        {
            $model->setAttributes($defaults);
        }

        if ($parentRelation)
        {
            $model->setParentRelation($parentRelation);
            $defaults['parentRelation'] = $parentRelation;
        }

        $body = Yii::$app->request->getBodyParams();

        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = 'json';

            $model->load($body);
            $model->save();

            if ($model->errors)
                Yii::$app->response->setStatusCode(422);

            return $model->errors ?: $model;
        }

        if ($model->load($body) && $model->save())
        {
            $additional = !empty($body['additional']) && $body['additional'] === 'yes';

            Yii::$app->session->addFlash('success', $this->name . ' created successfully.' . ($additional ? ' ' . Html::a('View <i class="glyphicon glyphicon-new-window"></i>', ['view', 'id' => $model->id], ['target' => '_blank']) : null));

            if (!empty($body['additional']) && $body['additional'] === 'yes')
                return $this->refresh();

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render($this->getCustomViewPath('create'), [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $body = Yii::$app->request->getBodyParams();

        if ($model->load($body))
        {
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = 'json';

                return \yii\widgets\ActiveForm::validate($model);
            }

            if ($model->hasProperty('uploadAttributes') && !empty($model->uploadAttributes))
            {
                foreach ($model->uploadAttributes as $name => $attribute)
                {
                    $files = \yii\web\UploadedFile::getInstances($model, $name);

                    $value = array_filter(ArrayHelper::getValue($model, $attribute, []));

                    foreach ($files as $file)
                    {
                        $filename = join('.', [uniqid('', true), $file->extension]);

                        if ($file->saveAs(Yii::getAlias('@storage/uploads/') . $filename))
                        {
                            $value[] = array_replace((array) $file, [
                                'filename' => $filename,
                                'tempName' => null,
                            ]);
                        }
                        else
                        {
                            $model->addError($attribute, $file->error);
                        }
                    }

                    ArrayHelper::setValue($model, $attribute, array_values($value));
                }
            }

            if ($model->save())
            {
                Yii::$app->session->addFlash('success', $this->name . ' updated successfully.');
                return $this->refresh();
            }
        }

        return $this->render($this->getCustomViewPath('update'), [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        return $this->render($this->getCustomViewPath('view'), [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionArchive($id)
    {
        $model = $this->findModel($id);

        if ($model->softDelete())
            Yii::$app->session->addFlash('success', $this->name . ' archived successfully.');
        else
            Yii::$app->session->addFlash('error', 'Error archiving ' . strtolower($this->name) . '.');

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete())
            Yii::$app->session->addFlash('success', $this->name . ' deleted successfully.');
        else
            Yii::$app->session->addFlash('error', 'Error deleting ' . strtolower($this->name) . '.');

        return $this->redirect(['index']);
    }

    public function getFields($model = null)
    {
        $fields = $this->fields;

        foreach ($fields as $name => &$options)
        {
            if (is_int($name))
            {
                foreach ($options as $key => &$value)
                {
                    $this->formatField($value, $model);
                }
            }
            else
            {
                $this->formatField($options, $model);
            }
        }

        return $fields;
    }

    private function formatField(&$options, $model = null)
    {
        $options = array_replace_recursive([
            'type' => 'textInput',
            'hint' => null,
            'modal' => [],
            'options' => [],
            'data' => [],
            'text_type' => null,
        ], $options);

        if (strpos($options['type'], '\\') !== false || strpos($options['type'], '.') !== false)
        {
            list($key, $text_type) = explode('.', $options['type']);

            $options['type'] = $key;
            $options['text_type'] = $text_type;
        }

        if (!empty($options['options']['data']) && is_string($options['options']['data']))
            $options['options']['data'] = $this->{$options['options']['data']};

        if ($options['type'] === 'widget' && $options['text_type'] === 'kartik\select2\Select2')
        {
            $attribute = ArrayHelper::getValue($options, 'attribute');
            $url = ArrayHelper::getValue($options, 'options.pluginOptions.ajax.url');

            if (is_array($url))
            {
                $urlParts = $url;
                $url = array_shift($urlParts);
            }
            else
            {
                $urlParts = [];
            }

            if ($model && $filterDataModel = ArrayHelper::getValue($options, 'dataModel'))
            {
                $_value = ArrayHelper::getValue($model, $attribute);
                if ($_value) {
                    $options['options']['data'] = [$_value => (string) ($filterDataModel)::findOne($_value)];
                }
            }

            unset($options['filterDataModel']);

            if (strpos($url, '@api.') === 0)
            {
                $getFields = join(',', ['id', ArrayHelper::getValue($options, 'options.pluginOptions.ajax.textColumn', 'name')]);

                $options['options']['pluginOptions']['ajax']['url'] = Yii::$app->apiUrlManager->createAbsoluteUrl(array_replace_recursive($urlParts, [substr($url, 5), 'access-token' => $this->api_key, 'fields' => $getFields]));
                $options['options']['pluginOptions']['ajax']['processResults'] = new JsExpression('function (results, params){ return {results:results}; }');
            }

            if ($templateResult = ArrayHelper::getValue($options, 'options.pluginOptions.templateResult'))
                $options['options']['pluginOptions']['templateResult'] = new JsExpression('function(result) { return result.' . $templateResult . ' || result.text; }');

            if ($templateSelection = ArrayHelper::getValue($options, 'options.pluginOptions.templateSelection'))
                $options['options']['pluginOptions']['templateSelection'] = new JsExpression('function (result) { return result.' . $templateSelection . ' || result.text; }');
        }
    }

    public function getColumns($searchModel = null, $columns = null)
    {
        if (!$columns) {
            $columns = $this->columns;
        }

        foreach ($columns as &$column)
        {
            if (is_string($column) || ArrayHelper::getValue($column, 'filterType') !== '\kartik\select2\Select2') continue;

            $attribute = ArrayHelper::getValue($column, 'attribute');
            $url = ArrayHelper::getValue($column, 'filterWidgetOptions.pluginOptions.ajax.url');

            if (is_array($url))
            {
                $urlParts = $url;
                $url = array_shift($urlParts);
            }
            else
            {
                $urlParts = [];
            }

            if ($searchModel && $filterDataModel = ArrayHelper::getValue($column, 'filterDataModel'))
            {
                $_value = ArrayHelper::getValue($searchModel, $attribute);
                if ($_value) {
                    $column['filterWidgetOptions']['data'] = [$_value => (string) ($filterDataModel)::findOne($_value)];
                }
            }

            unset($column['filterDataModel']);

            if (strpos($url, '@api.') === 0)
            {
                $getFields = join(',', ['id', ArrayHelper::getValue($column, 'filterWidgetOptions.pluginOptions.ajax.textColumn', 'name')]);

                $column['filterWidgetOptions']['pluginOptions']['ajax']['url'] = Yii::$app->apiUrlManager->createAbsoluteUrl(array_replace_recursive($urlParts, [substr($url, 5), 'access-token' => $this->api_key, 'fields' => $getFields]));
                $column['filterWidgetOptions']['pluginOptions']['ajax']['processResults'] = new JsExpression('function (results, params){ return {results:results}; }');
            }

            if ($data = ArrayHelper::getValue($column, 'filterWidgetOptions.pluginOptions.ajax.data'))
                $column['filterWidgetOptions']['pluginOptions']['ajax']['data'] = new JsExpression('function(params) { return {' . $data . ':params.term, page: params.page}; }');

            if ($templateResult = ArrayHelper::getValue($column, 'filterWidgetOptions.pluginOptions.templateResult'))
                $column['filterWidgetOptions']['pluginOptions']['templateResult'] = new JsExpression('function(result) { return result.' . $templateResult . ' || result.text; }');

            if ($templateSelection = ArrayHelper::getValue($column, 'filterWidgetOptions.pluginOptions.templateSelection'))
                $column['filterWidgetOptions']['pluginOptions']['templateSelection'] = new JsExpression('function (result) { return result.' . $templateSelection . ' || result.text; }');

            // die('<pre>'.print_r($column, 1).'</pre>');
        }

        return $columns;
    }

    protected function getApi_key()
    {
        if ($this->_key) return $this->_key;

        $key = Yii::$app->user->identity->getApi_keys()->one();

        if (!$key)
        {
            $key = new \ethercreative\apie\models\user\ApiKey;
            $key->user_id = Yii::$app->user->id;

            if ($key->save())
            {
                return $this->_key = $key->token;
            }
        }

        return $this->_key = $key->token;
    }
   
}

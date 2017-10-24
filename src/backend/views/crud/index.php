<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\Pjax;
use kartik\grid\GridView;
?>

<div class="row">
    <div class="col-md-12">
        <h1><?= Inflector::pluralize(Yii::$app->controller->name) ?></h1>

        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Create', array_merge(['create'], $defaults), ['class' => 'btn btn-primary']) ?>

        <hr>

        <?= $this->context->renderPartial($this->context->getCustomViewPath('') . '/_tabs', ['tabs' => Yii::$app->controller->getTab('index'), 'model' => $searchModel]); ?>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns,
        ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>

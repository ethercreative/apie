<?php
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

foreach ($modals as $key => $modal)
{
    Modal::begin([
        'header' => "<h2>{$modal['title']}</h2>",
        'toggleButton' => array_replace_recursive(['label' => 'click me', 'class' => 'hide', 'id' => 'modal-button-' . $key], ArrayHelper::getValue($modal, 'toggleButton', [])),
    ]);

    if (strpos($modal['content'], '@') !== false)
    {
        Pjax::begin();

        echo $this->render($modal['content'], array_merge([
            'model' => new $modal['model'],
        ], ArrayHelper::getValue($modal, 'options', [])));

        if (!empty($modal['js']))
            $this->registerJs($modal['js']);

        Pjax::end();
    }
    else
    {

    }

    Modal::end();
}

?>

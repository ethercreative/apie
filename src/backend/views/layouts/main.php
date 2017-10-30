<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use ethercreative\apie\backend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $guest = [
        ['label' => '<i class="glyphicon glyphicon-log-in"></i> Login', 'url' => ['/default/login']],
    ];

    $auth = [
        ['label' => '<i class="glyphicon glyphicon-dashboard"></i> Dashboard', 'url' => ['/dashboard/index']],
        ['label' => '<i class="glyphicon glyphicon-user"></i> Users', 'url' => ['/user/index']],
        ['label' => '<i class="glyphicon glyphicon-briefcase"></i> Teams', 'url' => ['/team/index']],
        ['label' => '<i class="glyphicon glyphicon-envelope"></i> Email Templates', 'url' => ['/email-templates']],
        '<li>'
        . Html::beginForm(['/default/logout'], 'post')
        . Html::submitButton(
            '<i class="glyphicon glyphicon-log-out"></i> Logout',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>'
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => Yii::$app->user->isGuest ? $guest : $auth,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => Yii::$app->controller->hasProperty('breabcrumbs') ? Yii::$app->controller->breadcrumbs : [],
            'homeLink' => ['label' => '<i class="glyphicon glyphicon-home"></i>'],
            'encodeLabels' => false,
        ]) ?>

        <?php

        $subNav = Yii::$app->controller->hasProperty('subNav') ? Yii::$app->controller->subNav : null;

        if ($subNav)
        {
            NavBar::begin([
                'options' => [
                    // 'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $subNav,
            ]);

            NavBar::end();
        }

        ?>
        
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

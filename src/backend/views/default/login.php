<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="site-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>Login</h1>

            <hr>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'max-length' => 128]) ?>

            <?= $form->field($model, 'password')->passwordInput(['max-length' => 32]) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?><br><br>
                    <?= Html::a('Forgotten your password?', ['forgotten']); ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="site-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>Reset Password</h1>

            <hr>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
            ]); ?>

            <?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true, 'max-length' => 128]) ?>

            <?= $form->field($model, 'confirm_password')->passwordInput(['autofocus' => true, 'max-length' => 128]) ?>

            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Set new password', ['class' => 'btn btn-primary']) ?><br><br>
                    <?= Html::a('Back to login', ['login']); ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

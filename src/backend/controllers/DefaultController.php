<?php

namespace ethercreative\apie\backend\controllers;

use Yii;

class DefaultController extends Controller
{
    public
        $forgottenFormClass = 'ethercreative\apie\models\ForgottenForm',
        $loginFormClass = 'ethercreative\apie\models\LoginForm',
        $resetClass = 'ethercreative\apie\models\user\Reset',
        $resetFormClass = 'ethercreative\apie\models\ResetForm',
        $viewPath = '@apie/backend/views/default';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['access']);

        return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => $this->getCustomViewPath('error'),
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->redirect(['login']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new $this->loginFormClass;

        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goBack();
            
        return $this->render($this->getCustomViewPath('login'), [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            Yii::$app->session->addFlash('success', 'Logged out successfully.');
        }

        return $this->redirect(['index']);
    }

    public function actionForgotten()
    {
        $model = new $this->forgottenFormClass;

        if ($model->load(Yii::$app->request->post()) && $model->reset())
        {
            Yii::$app->session->addFlash('success', 'If there is an account associated with that email address, a recovery email has been sent.');
            return $this->goBack();
        }

        return $this->render($this->getCustomViewPath('forgotten'), [
            'model' => $model,
        ]);
    }

    public function actionReset($code)
    {
        $reset = $this->findModel(['and', ['code' => $code], ['>', 'expires_at', 'NOW()']], [
            'modelClass' => $this->resetClass,
            'message' => 'That code does not exist, or has expired.'
        ]);

        $model = new $this->resetFormClass;
        $model->reset = $reset;

        if ($model->load(Yii::$app->request->post()) && $model->reset())
        {
            Yii::$app->session->addFlash('success', 'Password reset successfully.');
            return $this->goBack();
        }

        return $this->render($this->getCustomViewPath('reset'), [
            'model' => $model,
        ]);
    }
}

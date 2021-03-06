<?php


namespace app\controllers;


use app\models\ChangePassword;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAccount()
    {
        return $this->render('account', [
            'model' => $this->findModel(Yii::$app->user->identity->getId()),
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword();

        if ($model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Your password was changed successfully');
            return $this->redirect('account');
        } elseif (!$model->changePassword() && empty($_POST)) {
            return $this->render('change-password', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Password was not changed, try again');
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateData()
    {
        $model = $this->findModel(Yii::$app->user->identity->getId());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your data was changed successfully');
            return $this->redirect('account');
        } elseif (!($model->load(Yii::$app->request->post()) && $model->save()) && empty($_POST)) {
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Your data was not changed successfully');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeleteAccount()
    {
        $this->findModel(Yii::$app->user->identity->getId())->delete();

        return $this->redirect(['site/index']);
    }
} 

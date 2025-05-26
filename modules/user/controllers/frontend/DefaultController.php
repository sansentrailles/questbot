<?php

declare(strict_types=1);

namespace app\modules\user\controllers\frontend;

use app\modules\user\forms\frontend\EmailConfirmForm;
use app\modules\user\forms\frontend\PasswordResetForm;
use app\modules\user\forms\frontend\PasswordResetRequestForm;
use app\modules\user\forms\frontend\SignupForm;
use app\modules\user\forms\LoginForm;
use app\modules\user\Module;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @var \app\modules\user\Module
     */
    public $module;

    public $layout = '@app/modules/user/views/backend/layouts/main-login';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        echo 'index';
        exit;
        return $this->redirect(['profile/index'], 301);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm($this->module->defaultRole);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('success', Module::t('common', 'FLASH_EMAIL_CONFIRM_REQUEST'));
                return $this->redirect(['message']);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', Module::t('common', 'FLASH_EMAIL_CONFIRM_SUCCESS'));
        } else {
            Yii::$app->getSession()->setFlash('error', Module::t('common', 'FLASH_EMAIL_CONFIRM_ERROR'));
        }

        return $this->redirect(['message']);
    }

    public function actionPasswordResetRequest()
    {
        $model = new PasswordResetRequestForm($this->module->passwordResetTokenExpire);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Module::t('common', 'FLASH_PASSWORD_RESET_REQUEST'));

                return $this->redirect(['message']);
            }
            Yii::$app->getSession()->setFlash('error', Module::t('common', 'FLASH_PASSWORD_RESET_ERROR'));
        }

        return $this->render('passwordResetRequest', [
            'model' => $model,
        ]);
    }

    public function actionPasswordReset($token)
    {
        try {
            $model = new PasswordResetForm($token, $this->module->passwordResetTokenExpire);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Module::t('common', 'FLASH_PASSWORD_RESET_SUCCESS'));

            return $this->redirect(['message']);
        }

        return $this->render('passwordReset', [
            'model' => $model,
        ]);
    }

    public function actionError(): void
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMessage()
    {
        $message = '';
        $type = 'none';

        if ($message = Yii::$app->getSession()->getFlash('success')) {
            $type = 'success';
        } elseif ($message = Yii::$app->getSession()->getFlash('error')) {
            $type = 'error';
        }

        if (empty($message)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('message', [
            'message' => $message,
            'type' => $type,
        ]);
    }
}

<?php declare(strict_types=1);

use app\modules\user\models\User;
use app\modules\user\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\user\models\User $model */
/** @var yii\widgets\ActiveForm $form */
$isDev = Yii::$app->user->can('dev');

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'is_system')->checkbox(); ?>

    <?php echo $form->field($model, 'email')->textInput(); ?>

    <?php echo $form->field($model, 'phone')->textInput(); ?>

    <?php echo $form->field($model, 'access_token')->textInput(); ?>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->field($model, 'lastname')->textInput(); ?>
            </div>

            <div class="col-md-6">
                <?php echo $form->field($model, 'firstname')->textInput(); ?>
            </div>

        </div>
    </div>

    <?php echo $form->field($model, 'status')->dropDownList(User::getStatusesArray(), [
        'prompt' => 'Укажите статус',
    ]); ?>

    <?php echo $form->field($model, 'role')->dropDownList(
        ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
        ['options' => !empty($model->user->role) ?
            [
                $model->user->role => ['Selected'=>'selected'],
            ] :
            [
                Yii::$app->controller->module->defaultRole => ['Selected'=>'selected'],
            ],
        ]
    ); ?>

    <?php echo $form->field($model, 'new_password')->passwordInput(); ?>

    <?php echo $form->field($model, 'new_password_repeat')->passwordInput(); ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        );
?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

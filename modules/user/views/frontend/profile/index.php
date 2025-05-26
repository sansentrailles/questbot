<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

// @var $this yii\web\View
// @var $model app\modules\user\models\User

$this->title = Module::t('common', 'TITLE_PROFILE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Module::t('common', 'BUTTON_UPDATE'), ['update'], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Module::t('common', 'LINK_PASSWORD_CHANGE'), ['password-change'], ['class' => 'btn btn-primary']); ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'firstname',
            'lastname',
            'email',
            'phone',
        ],
    ]); ?>

</div>

<?php declare(strict_types=1);

use app\modules\seo\Module;

// @var $this yii\web\View
// @var $model app\modules\seo\models\Seo

$this->title = Module::t('common', 'SEO_UPDATE') . ': ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SEO'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('common', 'BUTTON_UPDATE') . ' ' . $model->title;
$this->params['boxheader'] = [
    'icon' => 'fa-search',
    'text' => $this->title,
];
?>
<div class="seo-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'section' => $section,
        'redirectUrl' => $redirectUrl,
    ]); ?>

</div>

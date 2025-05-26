<?php declare(strict_types=1);

use app\modules\seo\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$url = ['/admin/seo/seo'];

if (!empty($refId)) {
    $url['refId'] = $refId;
}

if (!empty($section)) {
    $url['section'] = $section;
}

if (!empty($redirectUrl)) {
    $url['redirectUrl'] = $redirectUrl;
}

$btnText = $isNew ? 'SEO_CREATE' : 'SEO_UPDATE';
?>

<?php echo Html::a(Module::t('common', $btnText), Url::to($url), ['class' => 'btn btn-primary']); ?>

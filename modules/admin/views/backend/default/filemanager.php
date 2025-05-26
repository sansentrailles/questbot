<?php declare(strict_types=1);

use app\modules\admin\Module;

$this->title = Module::t('common', 'ADMIN_FILEMANAGER');
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-folder-o',
    'text' => $this->title,
];

$key = Yii::$app->params['rf_akey'];

?>


<iframe src="/plugins/responsivefilemanager/filemanager/dialog.php?type=0&lang=ru&relative_url=1&akey=<?php echo $key; ?>" align="left">
    Ваш браузер не поддерживает фреймы!
</iframe>

<style>
    iframe {
        width: 100%;
        height: 600px;
        border: none;
    }
</style>

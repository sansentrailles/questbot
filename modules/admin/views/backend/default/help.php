<?php

declare(strict_types=1);

use app\modules\admin\Module;

$this->title = Module::t('common', 'ADMIN_HELP');
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];

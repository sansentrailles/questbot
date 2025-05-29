<?php

declare(strict_types=1);

namespace app\modules\main\controllers\common;

use Yii;

abstract class Controller extends \app\custom\controllers\Controller
{
    // protected $employeeService;

    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        $container = Yii::$container;
        
        // $this->employeeService = $container->get(EmployeeService::class);

        parent::__construct($id, $module, $config);
    }
}

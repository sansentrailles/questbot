<?php

declare(strict_types=1);

namespace app\modules\main\forms\backend;

use app\custom\files\BaseImageFile;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\main\models\Employee;
use app\modules\main\models\traits\EmployeeAttributeLabelsTrait;
use yii\base\Model;

/**
 * EmployeeForm is the model behind the employee item form.
 */
class EmployeeForm extends Model
{
    use EmployeeAttributeLabelsTrait;
    use UploadFilesTrait;

    public $id;
    public $is_visible;
    public $year;
    public $image;
    public $imageFile;

    public $employeeImage;

    private $employee;

    public function __construct(Employee $employee = null, $config = [])
    {
        $this->employeeImage = new BaseImageFile(Employee::BUCKET_NAME_IMAGE);
        $this->employee = $employee;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->employee) {
            return;
        }

        $this->id         = $this->employee->id;
        $this->is_visible = $this->employee->is_visible;
        $this->year       = $this->employee->year;
        $this->image      = $this->employee->image;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['year'], 'integer'],
            [['year'], 'required', 'message' => 'Укажите год'],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->employee) {
            return false;
        }

        return true;
    }

    public function getEmployee()
    {
        if ($this->employee === null) {
            $this->employee = new Employee();
        }

        return $this->employee;
    }

    public function getPrimaryKey()
    {
        if ($this->employee) {
            return $this->employee->primaryKey;
        }

        return null;
    }

    public function getUploadOptions()
    {
        return [
            'imageFile' => [
                'image' => [
                    'transform' => [
                        $this->employeeImage->save(),
                    ],
                ],
            ],
        ];
    }

    public function getImagePath()
    {
        return $this->employee->imagePath;
    }
}

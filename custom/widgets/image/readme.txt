--Использование виджета
На форме
<?= $form->field($model, 'thumb')->widget(ImageWidget::className(), [
    'action' => Url::to(['/admin/item/upload-file']),
    'cropWidth' => 640,
    'cropHeight' => 250,
]) ?>

--Контроллер админки
use app\custom\widgets\image\ImageWidget;

public function actions()
{
    return [
        'upload-file' => [
            'class' => 'app\custom\widgets\image\UploadFileAction',
            'url' => '/tmp/items/',
            'width' => 640,
            'height' => 320,
        ],
    ];
}


--Модель
public function behaviors()
{
    return [
        [
            'class' => 'app\custom\widgets\image\ImageBehavior',
            'storePath' => 'images/news',   // путь для сохранения
            'attribute' => 'thumb',         // атрибут, в котором хранится картинка
        ]
    ];
}





















public function behaviors()
{
    return [
        [
            'class' => 'app\custom\widgets\image\ImageBehavior',
            'storePath' => 'items',
            'attribute' => 'thumb',
        ]
    ];
}

public $path = '@webroot/images/tmp';
public $url = '/images/tmp';
public $uploadParam = 'file';
public $maxSize = 2097152;
public $extensions = 'jpeg, jpg, png, gif';
public $width = 200;
public $height = 200;

public function actions()
{
    return [
        'upload-file' => [
            'class' => 'app\custom\widgets\image\UploadFileAction',
            // 'uploadPath' => 'uploads/',
        ],
    ];
}


<?= $form->field($model, 'thumb')->widget(ImageWidget::className(), [
    // 'uploadUrl' => Url::toRoute('/admin/gallery/uploadPhoto'),
    'width' => 320,
    'height' => 210,
    'cropWidth' => 640,
    'cropHeight' => 420,
    // 'maxSize' => 8097152
]) ?>
<?php

declare(strict_types=1);

namespace app\modules\user;

use Yii;

/**
 * user module definition class.
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @var string
     */
    public $defaultRole = 'user';

    /**
     * @var int
     */
    public $passwordResetTokenExpire = 3600;

    /**
     * @var string path to mail templates
     */
    public $mailTemplatesPath = '@app/modules/user/mails';

    /**
     * @var string path to mail layouts
     */
    public $mailHtmlLayoutsPath = '@app/modules/user/mails/layouts/html';

    /**
     * @var string path to mail layouts
     */
    public $mailTextLayoutsPath = '@app/modules/user/mails/layouts/text';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        Yii::$app->mailer->htmlLayout = $this->mailHtmlLayoutsPath;
        Yii::$app->mailer->textLayout = $this->mailTextLayoutsPath;
        // custom initialization code goes here
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/user/' . $category, $message, $params, $language);
    }
}

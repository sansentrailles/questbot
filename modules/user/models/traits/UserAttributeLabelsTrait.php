<?php

declare(strict_types=1);

namespace app\modules\user\models\traits;

use app\modules\user\Module;

trait UserAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Module::t('common', 'ID'),
            'fullname'            => Module::t('common', 'USER_FULLNAME'),
            'email'               => Module::t('common', 'USER_EMAIL'),
            'lastname'            => Module::t('common', 'USER_LASTNAME'),
            'firstname'           => Module::t('common', 'USER_FIRSTNAME'),
            'middlename'          => Module::t('common', 'USER_MIDDLENAME'),
            'phone'               => Module::t('common', 'USER_PHONE'),
            'status'              => Module::t('common', 'USER_STATUS'),
            'password'            => Module::t('common', 'USER_PASSWORD'),
            'role'                => Module::t('common', 'USER_ROLE'),
            'new_password'        => Module::t('common', 'USER_NEW_PASSWORD'),
            'new_password_repeat' => Module::t('common', 'USER_NEW_PASSWORD_REPEAT'),
            'is_system'           => Module::t('common', 'USER_IS_SYSTEM'),
            'access_token'        => Module::t('common', 'USER_ACCESS_TOKEN'),
            'roles'               => Module::t('common', 'USER_ROLES'),
        ];
    }
}

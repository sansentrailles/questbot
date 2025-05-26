<?php

declare(strict_types=1);

namespace app\modules\user\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\user\models\User as Model;

class UserRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getByEmail($email)
    {
        return $this->model::findOne(['email' => $email]);
    }
}

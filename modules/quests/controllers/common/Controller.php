<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\common;

use Yii;
use app\modules\quests\services\QuizService;
use app\modules\quests\services\TaskService;
use app\modules\quests\services\QuestService;
use app\modules\quests\services\AnswerService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $questService;
    protected $taskService;
    protected $answerService;

    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        $container = Yii::$container;

        $this->questService = $container->get(QuestService::class);
        $this->taskService = $container->get(TaskService::class);
        $this->answerService = $container->get(AnswerService::class);

        parent::__construct($id, $module, $config);
    }
}

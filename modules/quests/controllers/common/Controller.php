<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\common;

use Yii;
use app\modules\quests\services\TaskService;
use app\modules\quests\services\QuestService;
use app\modules\quests\services\AnswerService;
use app\modules\quests\services\HintService;
use app\modules\quests\services\StatService;
use app\modules\quests\services\StatItemService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $questService;
    protected $taskService;
    protected $answerService;
    protected $hintService;
    protected $statService;
    protected $statItemService;

    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        $container = Yii::$container;

        $this->questService = $container->get(QuestService::class);
        $this->taskService = $container->get(TaskService::class);
        $this->answerService = $container->get(AnswerService::class);
        $this->hintService = $container->get(HintService::class);
        $this->statService = $container->get(StatService::class);
        $this->statItemService = $container->get(StatItemService::class);

        parent::__construct($id, $module, $config);
    }
}

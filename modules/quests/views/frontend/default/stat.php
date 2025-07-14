<?php

use app\custom\helpers\DateHelper;
use app\modules\quests\models\Task;

$correctsCount = 0;

?>

<!-- Навигация -->
<header class="max-w-4xl mx-auto mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-pink-300 to-red-400"> Статистика прохождения прогулки </h1>
</header>
<!-- Квест -->
<section class="max-w-4xl mx-auto space-y-6 mb-10">
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-yellow-300 mb-2"><?= $quest->title ?></h2>

            <?php if ($quest->image) { ?>
                <img src="<?= $quest->imagePath ?>" alt="" class="w-full h-40 object-cover rounded-lg my-4">
            <?php } ?>
            <p class="text-gray-300 leading-relaxed mb-3"> Исследуйте скрытые уголки исторического центра и разгадайте загадки прошлого. </p>
            <p class="text-gray-400 text-sm">
                <strong>Начало:</strong> <?= DateHelper::formatTimestampRu($stat->start); ?>
            </p>
            <p class="text-gray-400 text-sm">
                <strong>Завершение:</strong> <?= DateHelper::formatTimestampRu($stat->finish); ?>
            </p>
            <p class="text-gray-400 text-sm">
                <strong>Продолжительность:</strong> <?= DateHelper::formatTimeDiffImproved((int) $stat->start, (int) $stat->finish); ?>
            </p>
        </div>
    </div>
</section>

<!-- Вопросы -->
<main class="max-w-4xl mx-auto space-y-6">
    <?php foreach ($items as $item) {
            $task = $item->task;

            if ($item->is_correct) {
                $correctsCount += 1;
            }
        ?>
        <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in" style="animation-delay: 0s;">
            <div class="p-6">
                <p class="text-xl font-semibold text-pink-300 mb-3"><?= str_replace("\n", "<br>", $item->question) ?></p>

                <?php if ($task->image) { ?>
                    <img src="<?= $task->imagePath ?>" alt="Изображение вопроса" class="h-32 object-cover rounded-lg my-4 mx-auto">
                <?php } ?>
                
                <?php if ($task->type == Task::TYPE_CHOICE) { ?>
                    <?= $this->render('inner/answers', [
                        'answers' => $task->answers,
                    ]) ?>
                <?php } else { ?>
                    <p class="text-gray-300 mb-2"><strong>Правильный ответ:</strong> <?= $item->task_answer ?></p>
                <?php } ?>

                <p class="text-gray-300 mb-2">
                    <strong>Ответ пользователя:</strong> <?= $item->user_answer ?>
                </p>

                <?php if ($item->is_correct) { ?>
                    <p class="text-green-400 font-medium mb-2">✅ Верно</p>
                <?php  } else { ?>
                    <p class="text-red-400 font-medium mb-2">❌ Неверно</p>
                <?php } ?>
            

                <p class="text-gray-400 text-sm">
                    <strong>Время ответа:</strong> <?= date("H:i", $item->created_at) ?>
                </p>
                <?php if ((int) $item->hint_count > 0) { ?>
                    <p class="text-gray-400 text-sm">Подсказки использовано: <?= (int) $item->hint_used ?> из <?= $item->hint_count ?></p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!-- Итог -->
    <section class="max-w-4xl mx-auto mt-10">
        <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 p-6 text-center animate-fade-in" style="animation-delay: 0.4s;">
            <h2 class="text-2xl font-bold text-green-400 mb-2">Итог прохождения</h2>
            <p class="text-gray-300 text-lg"> Верных ответов: <span class="font-semibold">2</span> из <span class="font-semibold"><?= count($items) ?></span>
            </p>
        </div>
    </section>

    <!-- Примечание -->
    <section class="max-w-4xl mx-auto mt-8">
        <div class="bg-yellow-900/30 backdrop-blur-md rounded-xl shadow-inner border border-yellow-800/30 p-4 text-center animate-fade-in" style="animation-delay: 0.5s;">
            <p class="text-yellow-300 text-sm">
                <strong>Примечание:</strong> Определение правильности некоторых ответов может работать некорректно.
            </p>
        </div>
    </section>
</main>


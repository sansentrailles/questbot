<?php

use yii\helpers\Html;

$descParts = explode("\n", $quest->desc);
$helpParts = explode("\n", $quest->help);

?>


<!-- Навигация -->
<header class="max-w-4xl mx-auto mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-pink-300 to-red-400"> Прогулка </h1>
    <?php /*<a href="quests.html" class="text-sm text-gray-300 hover:text-white transition">← К списку квестов</a> */?>
</header>

<!-- Основная информация о квесте -->
<section class="max-w-4xl mx-auto space-y-6 mb-10">
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-yellow-300 mb-2"><?= $quest->title ?></h2>
            <span class="inline-block px-3 py-1 bg-blue-900/50 rounded-full text-xs text-blue-300 mb-4">Городской квест</span>
            <?php if ($quest->image) { ?>
                <img src="<?= $quest->imagePath ?>" alt="<?= Html::encode("Прогулка - ". $quest->title) ?>" class="w-full h-auto rounded-lg my-4" />
            <?php } ?>

            <p class="text-gray-300 leading-relaxed mb-3"> <?= $quest->announce ?> </p>
            <p class="text-gray-400 text-sm mb-6">
                <strong>Количество точек маршрута:</strong> <?= count($tasks) ?>
            </p>

            <div class="mb-4 border-b border-white/10">
                <div class="flex -mb-px">
                    <button onclick="openTab(event, 'info')" class="tab-button active flex items-center gap-2 text-white bg-blue-900/50 px-4 py-2 mr-2 rounded-t-lg transition"> 📘 Информация </button>
                    <button onclick="openTab(event, 'help')" class="tab-button flex items-center gap-2 text-gray-300 hover:bg-blue-900/30 px-4 py-2 rounded-t-lg transition"> ❓ Справка </button>
                </div>
            </div>

            <div id="info" class="tab tab-content active">
                <?php foreach ($descParts as $k => $line) { ?>
                    <p class="text-gray-300<?php if ($k == 0) { ?> mb-4<?php } ?>"> <?= $line ?> </p>
                <?php } ?>
            </div>
            <div id="help" class="tab tab-content hidden">
                <?php foreach ($helpParts as $k => $line) { ?>
                    <p class="text-gray-300<?php if ($k == 0) { ?> mb-4<?php } ?>"> <?= $line ?> </p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Предупреждение -->
    <section class="mb-6">
        <div style="background-color: rgba(234, 179, 8); color: #1c1917; padding: 1rem; border-radius: 0.75rem; border-left: 4px solid #facc15; display: flex; align-items: start; gap: 1rem;">
            <svg style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <div>
                <strong style="font-weight: bold; display: block; margin-bottom: 0.25rem;">Информация</strong>
                <p style="font-size: 0.875rem; line-height: 1.5;">
                    При прохождении прогулки по Web-версии ваша статистика не сохраняется.
                    Подсказки можно открывать, но они не будут учтены в финальной статистике.
                </p>
            </div>
        </div>
    </section>
</section>

<?= $this->render('inner/tasks', [
    'tasks' => $tasks,
]) ?>
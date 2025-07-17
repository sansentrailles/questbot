<?php

use yii\helpers\Html;

$desc = str_replace("\n\n", "<br>", $quest->desc);
$descParts = explode("\n", $desc);
$help = str_replace("\n\n", "<br>", $quest->help);
$helpParts = explode("\n", $help);

?>

<header class="flex justify-between items-center">
    <h1 class="text-2xl text-white-400"> Познавательная прогулка-викторина </h1>
    <?php /*
    <a href="quests.html" class="text-sm text-gray-300 hover:text-white transition">← К списку квестов</a>
    */ ?>
</header>

<!-- Основная информация о квесте -->
<section class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in mb-10">
    <div class="p-6">
        <h2 class="text-4xl font-bold text-yellow-300 mb-2"><?= $quest->title ?></h2>
        <?php /*
        <span class="inline-block px-3 py-1 bg-blue-900/50 rounded-full text-blue-300 mb-4">Городской квест</span>
        */ ?>

        <?php if ($quest->image) { ?>
            <img src="<?= $quest->imagePath ?>" alt="<?= Html::encode("Прогулка - ".$quest->title) ?>" class="w-full h-auto rounded-lg my-4">
        <?php } ?>

        <p class="text-gray-300 leading-relaxed mb-3"><?= $quest->announce ?></p>
        <p class="text-gray-400 mb-6">
            <strong>Количество точек маршрута:</strong> <?= $tasksCount ?>
        </p>

        <!-- Вкладки -->
        <div class="border-b border-white/10">
            <div class="flex -mb-px">
                <button onclick="openTab(event, 'info')" class="tab-button active text-white bg-blue-900/50 px-4 py-2 mr-2 rounded-t-lg transition duration-300"> 📘 Информация </button>

                <?php if ($quest->help) { ?>
                    <button onclick="openTab(event, 'help')" class="tab-button text-gray-300 hover:bg-blue-900/30 px-4 py-2 rounded-t-lg transition duration-300"> ❓ Справка </button>
                <?php } ?>
            </div>
        </div>

        <!-- Содержимое вкладок -->
        <div id="info" class="tab tab-content active p-4 bg-blue-900/50 rounded-b-lg rounded-l-lg">
            <?php foreach ($descParts as $k => $line) { ?>
                <p class="text-gray-300<?php if ($k == 0) { ?> mb-4<?php } ?>"> <?= $line ?> </p>
            <?php } ?>
        </div>

        <div id="help" class="tab tab-content hidden p-4 bg-blue-900/50 rounded-b-lg rounded-l-lg">
            <?php foreach ($helpParts as $k => $line) { ?>
                <p class="text-gray-300<?php if ($k == 0) { ?> mb-4<?php } ?>"> <?= $line ?> </p>
            <?php } ?>
        </div>
    </div>
</section>

<?php if($quest->is_active) { ?>
    <?= $this->render('inner/_quest_tasks', [
        'tasks' => $tasks,
    ]) ?>
<?php } ?>

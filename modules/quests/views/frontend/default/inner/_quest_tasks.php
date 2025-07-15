<section id="questions-section" class="space-y-6">
    <?php foreach ($tasks as $task) {
        $question = str_replace("\n\n", "<br>", $task->question);
        $questionParts = explode("\n", $question);
        $answers = $task->answers;
        $hints = $task->visibleHints;
    ?>
        <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
            <div class="p-6">
                <?php /*
                <h3 class="text-xl font-semibold text-pink-300 mb-3">Загадка Старой Площади</h3>
                */ ?>
                <?php if ($task->image) { ?>
                    <img src="<?= $task->imagePath ?>" alt="Изображение вопроса" class="w-full h-auto rounded-lg my-4 mx-auto">
                <?php } ?>

                <?php /*
                <p class="text-gray-300 mb-4">Найдите каменную плиту с выбитыми символами и прочитайте надпись.</p>
                */ ?>

                <div class="task-question mb-6">
                    <?php foreach ($questionParts as $k => $line) { ?>
                        <p class="text-gray-300<?php if ($k == 0) { ?> mb-4<?php } ?>"> <?= $line ?> </p>
                    <?php } ?>
                </div>
                

                <?php if (count($answers) > 0) { ?>
                    <div class="mb-6">
                        <p class="text-gray-400 mb-2">Варианты ответов:</p>
                        <ul class="list-disc list-inside text-gray-300 ml-4 space-y-1">
                            <?php foreach ($answers as $answer) { ?>
                                <li><?= $answer->title ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                    
                <?php if (count ($hints) > 0) { ?>
                    <div class="mt-6">
                        <button onclick="showNextHint(this)" class="text-blue-400 hover:underline mb-2 block"> Показать подсказку 🔎</button>
                        <div class="space-y-2">
                            <?php foreach ($hints as $k => $hint) {
                                $i = $k + 1;
                            ?>
                                <p class="text-gray-300 hint hidden"><b class="text-yellow-200">Подсказка <?= $i?>:</b> <?= $hint->text ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($task->place_show) { ?>
                    <div class="mt-6">
                        <button onclick="toggleLocation(this)" class="text-blue-400 hover:underline mb-2 block"> Показать место 🌎</button>
                        <div class="location hidden mt-2 p-3 bg-gray-800/50 rounded-lg border border-gray-700">
                            <p class="text-gray-300">Место: <?= $task->place ?></p>
                            <p class="text-gray-300">Адрес: <?= $task->address ?></p>
                            <?php if ($task->longitude && $task->latitude) {
                                $mapLink = "https://yandex.ru/maps/?ll=$task->longitude}%2C{$task->latitude}&z=17";
                            ?>
                                <p class="mt-4">
                                    <a class="text-blue-400" href="<?= $mapLink ?>" target="_blank">Посмотреть на карте 🌎</a>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</section>
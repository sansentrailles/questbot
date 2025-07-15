<!-- Блок вопросов -->
<section class="max-w-4xl mx-auto space-y-6 mb-10" id="questions-section">

<?php /*
<section class="container mb-10" id="questions-section">
*/?>
    <!-- Вопрос 1 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
    <?php /*
    <div class="card">
    */ ?>
        <div class="p-6">
            <img src=" https://placehold.co/600x200/ef4444/ffffff?text=Плитка+с+символами" alt="Изображение вопроса" class="h-auto rounded-lg my-4 mx-auto">

            <p style="margin-bottom: 1rem;" class="text-white-500 text-lg"> Найдите каменную плиту с выбитыми символами и прочитайте надпись. </p>
            <!-- Варианты ответов -->
            <div style="margin-bottom: 1.5rem;">
                <p style="color: #9ca3af; margin-bottom: 0.5rem;">Варианты ответов:</p>

                <?php /*
                <ul style="list-style: disc inside; padding-left: 1.5rem; font-size: 0.875rem; line-height: 1.5;">
                */ ?>
                <ul class="list-disc list-inside text-base">
                    <li>"Свет Забвения"</li>
                    <li>"Дыхание Прошлого"</li>
                    <li>"Путь Молчания"</li>
                </ul>
            </div>

            <!-- Подсказки -->
            <div class="mt-3 hint-group">
                <button onclick="showNextHint(this)" class="show-hint-btn text-blue-300"> Показать подсказку </button>
                <ul class="hints-container list-disc list-inside">
                    <li class="hint hidden text-gray-100 text-sm">Подсказка 1: Обратите внимание на резьбу слева.</li>
                    <li class="hint hidden text-gray-100 text-sm">Подсказка 2: Здесь когда-то был вход в подземелье.</li>
                </ul>
            </div>

            <!-- Место -->
            <div class="mt-2 location-wrapper">
                <button onclick="toggleLocation(this)" class="show-location-btn text-blue-300"> Показать место </button>
                <div class="hidden mt-2 rounded-md border-gray-400 border-solid border p-2 text-sm color-gray-500 bg-gray-100/25">
                    <p>Место: У памятника "Старая Площадь", у южной арки.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Вопрос 2 -->
    <div class="card">
        <h3>Тень Рыночных Аркад</h3>
        <p style="margin-bottom: 1rem;"> Ответьте на вопрос или найдите объект, связанный с этим местом. </p>
        <img src=" https://placehold.co/600x200/f97316/ffffff?text=Рынок" alt="Изображение вопроса">
        <!-- Варианты ответов -->
        <div style="margin-bottom: 1.5rem;">
            <p style="color: #9ca3af; margin-bottom: 0.5rem;">Варианты ответов:</p>
            <ul style="list-style: disc inside; padding-left: 1.5rem; font-size: 0.875rem; line-height: 1.5;">
                <li>"Рыбный рынок"</li>
                <li style="color: #4ade80; font-weight: 500;">✅ "Башня Сторожа" (правильный)</li>
                <li>"Фонтан Воспоминаний"</li>
            </ul>
        </div>
        <!-- Подсказки -->
        <div class="mt-6 hint-group">
            <button onclick="showNextHint(this)" class="show-hint-btn"> Показать подсказку </button>
            <div class="hints-container">
                <p class="hint hidden">Подсказка 1: Посмотрите на крышу.</p>
                <p class="hint hidden">Подсказка 2: Ищите вывеску с совой.</p>
            </div>
        </div>
        <!-- Место -->
        <div class="mt-6 location-wrapper">
            <button onclick="toggleLocation(this)" class="show-location-btn"> Показать место </button>
            <div class="location hidden mt-2">
                <p>Место: Рыночная площадь, у старой колонны.</p>
            </div>
        </div>
    </div>
</section>
<header class="flex justify-between items-center">
    <h1 class="text-2xl text-white-400"> Познавательная прогулка-викторина </h1>
    <?php /*
    <a href="quests.html" class="text-sm text-gray-300 hover:text-white transition">← К списку квестов</a>
    */ ?>
</header>

<!-- Основная информация о квесте -->
<section class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in mb-10">
    <div class="p-6">
        <h2 class="text-4xl font-bold text-yellow-300 mb-2">Тайны Старого Города</h2>
        <?php /*
        <span class="inline-block px-3 py-1 bg-blue-900/50 rounded-full text-blue-300 mb-4">Городской квест</span>
        */ ?>

        <img src="https://placehold.co/600x300/3b82f6/ffffff?text=Старый+город" alt="Квест: Тайны Старого Города" class="w-full h-auto rounded-lg my-4">

        <p class="text-gray-300 leading-relaxed mb-3"> Исследуйте скрытые уголки исторического центра и разгадайте загадки прошлого. </p>
        <p class="text-gray-400 mb-6">
            <strong>Количество точек маршрута:</strong> 7
        </p>

        <!-- Вкладки -->
        <div class="border-b border-white/10">
            <div class="flex -mb-px">
                <button onclick="openTab(event, 'info')" class="tab-button active text-white bg-blue-900/50 px-4 py-2 mr-2 rounded-t-lg transition duration-300"> 📘 Информация </button>
                <button onclick="openTab(event, 'help')" class="tab-button text-gray-300 hover:bg-blue-900/30 px-4 py-2 rounded-t-lg transition duration-300"> ❓ Справка </button>
            </div>
        </div>

        <!-- Содержимое вкладок -->
        <div id="info" class="tab tab-content active p-4 bg-blue-900/50 rounded-b-lg rounded-l-lg">
            <p class="text-gray-300 mb-4"> Это приключенческий маршрут по старинным зданиям, улицам и легендам города. Вы будете решать головоломки, находить подсказки и узнавать интересные факты о городе. </p>
            <p class="text-gray-300"> Пройдите все точки маршрута, чтобы раскрыть главную тайну Старого Города! </p>
        </div>

        <div id="help" class="tab tab-content hidden p-4 bg-blue-900/50 rounded-b-lg rounded-l-lg">
            <p class="text-gray-300 mb-4"> Чтобы успешно пройти квест, следуйте указаниям бота и внимательно читайте задания. </p>
            <p class="text-gray-300"> Используйте подсказки, если застряли, но помните — их количество ограничено. </p>
        </div>
    </div>
</section>

<!-- Заголовок перед вопросами -->
<h2 class="text-3xl font-bold text-yellow-300 mt-10 mb-4">Контрольные точки прогулки</h2>

<!-- Блок вопросов -->
<section id="questions-section" class="space-y-6">
    <!-- Вопрос 1 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
        <div class="p-6">
            <?php /*
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Загадка Старой Площади</h3>
            */ ?>
            <p class="text-gray-300 mb-4">Найдите каменную плиту с выбитыми символами и прочитайте надпись.</p>
            <img src=" https://placehold.co/600x200/ef4444/ffffff?text=Плитка+с+символами" alt="Изображение вопроса" class="w-full h-auto rounded-lg my-4 mx-auto">
            <!-- Варианты ответов -->
            <div class="mb-6">
                <p class="text-gray-400 mb-2">Варианты ответов:</p>
                <ul class="list-disc list-inside text-gray-300 ml-4 space-y-1">
                    <li>"Свет Забвения"</li>
                    <li class="text-green-400 font-medium">"Дыхание Прошлого" ✅</li>
                    <li>"Путь Молчания"</li>
                </ul>
            </div>

            <!-- Подсказки -->
            <div class="mt-6">
                <button onclick="showNextHint(this)" class="text-blue-400 hover:underline mb-2 block"> Показать подсказку </button>
                <div class="space-y-2">
                    <p class="text-gray-300 hint hidden">Подсказка 1: Обратите внимание на резьбу слева.</p>
                    <p class="text-gray-300 hint hidden">Подсказка 2: Здесь когда-то был вход в подземелье.</p>
                </div>
            </div>

            <!-- Место -->
            <div class="mt-6">
                <button onclick="toggleLocation(this)" class="text-blue-400 hover:underline mb-2 block"> Показать место </button>
                <div class="location hidden mt-2 p-3 bg-gray-800/50 rounded-lg border border-gray-700">
                    <p class="text-gray-300">Место: У памятника "Старая Площадь", у южной арки.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Вопрос 2 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Тень Рыночных Аркад</h3>
            <p class="text-gray-300 mb-4">Ответьте на вопрос или найдите объект, связанный с этим местом.</p>
            <img src=" https://placehold.co/600x200/f97316/ffffff?text=Рынок" alt="Изображение вопроса" class="w-full h-auto rounded-lg my-4 mx-auto">
            <!-- Варианты ответов -->
            <div class="mb-6">
                <p class="text-gray-400 mb-2">Варианты ответов:</p>
                <ul class="list-disc list-inside text-gray-300 ml-4 space-y-1">
                    <li>"Рыбный рынок"</li>
                    <li class="text-green-400 font-medium">"Башня Сторожа" ✅</li>
                    <li>"Фонтан Воспоминаний"</li>
                </ul>
            </div>
            <!-- Подсказки -->
            <div class="mt-6">
                <button onclick="showNextHint(this)" class="text-sm text-blue-400 hover:underline mb-2 block"> Показать подсказку </button>
                <div class="space-y-2">
                    <p class="text-gray-300 hint">Подсказка 1: Посмотрите на крышу.</p>
                    <p class="text-gray-300 hint hidden">Подсказка 2: Ищите вывеску с совой.</p>
                </div>
            </div>
            <!-- Место -->
            <div class="mt-6">
                <button onclick="toggleLocation(this)" class="text-sm text-blue-400 hover:underline mb-2 block"> Показать место </button>
                <div class="location hidden mt-2 p-3 bg-gray-800/50 rounded-lg border border-gray-700">
                    <p class="text-gray-300">Место: Рыночная площадь, у старой колонны.</p>
                </div>
            </div>
        </div>
    </div>
</section>
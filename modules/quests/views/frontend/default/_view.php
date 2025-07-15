<!-- Навигация -->
<header class="mb-6 flex justify-between items-center">
    <h1 class="text-title">Квест</h1>
    <a href="#" class="back-link">← К списку квестов</a>
</header>
<!-- Основная информация о квесте -->
<section class="card mb-6">
    <h2>Тайны Старого Города</h2>
    <span class="tag">Городской квест</span>
    <img src="https://placehold.co/600x300/3b82f6/ffffff?text=Старый+город" alt="Квест: Тайны Старого Города" />
    <p class="mb-4"> Исследуйте скрытые уголки исторического центра и разгадайте загадки прошлого. </p>
    <p class="text-gray-400 mb-6">
        <strong>Количество точек маршрута:</strong> 7
    </p>
    <!-- Вкладки -->
    <div class="tab-buttons mb-4">
        <button onclick="openTab(event, 'info')" class="tab-button active">📘 Информация</button>
        <button onclick="openTab(event, 'help')" class="tab-button">❓ Справка</button>
    </div>
    <div id="info" class="tab-content">
        <p> Это приключенческий маршрут по старинным зданиям, улицам и легендам города. Вы будете решать головоломки, находить подсказки и узнавать интересные факты. </p>
        <p class="mt-4"> Пройдите все точки маршрута, чтобы раскрыть главную тайну Старого Города! </p>
    </div>
    <div id="help" class="tab-content hidden">
        <p> Чтобы успешно пройти квест, следуйте указаниям бота и внимательно читайте задания. </p>
        <p class="mt-4"> Используйте подсказки, если застряли, но помните — их количество ограничено. </p>
    </div>
</section>
<!-- Блок вопросов -->
<section id="questions-section">
    <!-- Вопрос 1 -->
    <div class="card mb-6">
        <h3>Загадка Старой Площади</h3>
        <p class="mb-4">Найдите каменную плиту с выбитыми символами и прочитайте надпись.</p>
        <img src=" https://placehold.co/600x200/ef4444/ffffff?text=Плитка+с+символами" alt="Изображение вопроса" class="question-image" />
        <!-- Варианты ответов -->
        <div class="mb-6">
            <p class="mb-2 text-sm">Варианты ответов:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>"Свет Забвения"</li>
                <li class="correct-answer">✅ "Дыхание Прошлого" (правильный)</li>
                <li>"Путь Молчания"</li>
            </ul>
        </div>
        <!-- Подсказки -->
        <div class="mt-6 hint-group">
            <button onclick="toggleHint(this)" class="show-hint-btn">Показать подсказку</button>
            <div class="hint-box">
                <p class="hint">Подсказка 1: Обратите внимание на резьбу слева.</p>
                <p class="hint hidden">Подсказка 2: Здесь когда-то был вход в подземелье.</p>
            </div>
        </div>
        <!-- Место -->
        <div class="mt-6 location-wrapper">
            <button onclick="toggleLocation(this)" class="show-location-btn">Показать место</button>
            <div class="location hidden mt-2"> Место: У памятника "Старая Площадь", у южной арки. </div>
        </div>
    </div>
    <!-- Вопрос 2 -->
    <div class="card mb-6">
        <h3>Тень Рыночных Аркад</h3>
        <p class="mb-4">Ответьте на вопрос или найдите объект, связанный с этим местом.</p>
        <img src=" https://placehold.co/600x200/f97316/ffffff?text=Рынок" alt="Изображение вопроса" class="question-image" />
        <!-- Варианты ответов -->
        <div class="mb-6">
            <p class="mb-2 text-sm">Варианты ответов:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>"Рыбный рынок"</li>
                <li class="correct-answer">✅ "Башня Сторожа" (правильный)</li>
                <li>"Фонтан Воспоминаний"</li>
            </ul>
        </div>
        <!-- Подсказки -->
        <div class="mt-6 hint-group">
            <button onclick="toggleHint(this)" class="show-hint-btn">Показать подсказку</button>
            <div class="hint-box">
                <p class="hint">Подсказка 1: Посмотрите на крышу.</p>
                <p class="hint hidden">Подсказка 2: Ищите вывеску с совой.</p>
            </div>
        </div>
        <!-- Место -->
        <div class="mt-6 location-wrapper">
            <button onclick="toggleLocation(this)" class="show-location-btn">Показать место</button>
            <div class="location hidden mt-2"> Место: Рыночная площадь, у старой колонны. </div>
        </div>
    </div>
</section>

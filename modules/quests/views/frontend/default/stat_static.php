<?php

use app\modules\quests\models\Task;

?>

<!-- Навигация -->
<header class="max-w-4xl mx-auto mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-pink-300 to-red-400"> Статистика квеста </h1>
    <a href="quests.html" class="text-sm text-gray-300 hover:text-white transition">← К списку квестов</a>
</header>
<!-- Квест -->
<section class="max-w-4xl mx-auto space-y-6 mb-10">
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-yellow-300 mb-2">Тайны Старого Города</h2>
            <img src="https://placehold.co/600x300/3b82f6/ffffff?text=Старый+город" alt="Квест: Тайны Старого Города" class="w-full h-40 object-cover rounded-lg my-4">
            <p class="text-gray-300 leading-relaxed mb-3"> Исследуйте скрытые уголки исторического центра и разгадайте загадки прошлого. </p>
            <p class="text-gray-400 text-sm">
                <strong>Начало:</strong> 15 апреля 2025, 10:23
            </p>
            <p class="text-gray-400 text-sm">
                <strong>Завершение:</strong> 15 апреля 2025, 15:33
            </p>
            <p class="text-gray-400 text-sm"><strong>Продолжительность:</strong> 22 минуты</p>
        </div>
    </div>
</section>
<!-- Вопросы -->
<main class="max-w-4xl mx-auto space-y-6">
    <!-- Вопрос 1 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in" style="animation-delay: 0s;">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Вопрос 1: Где находится старинная башня?</h3>
            <img src=" https://placehold.co/600x200/ef4444/ffffff?text=Башня" alt="Изображение вопроса" class="w-full h-32 object-cover rounded-lg my-4">
            <div class="space-y-2 mb-4">
                <p class="text-gray-400">Варианты ответов:</p>
                <ul class="list-disc list-inside text-gray-300 ml-4">
                    <li>Площадь Свободы</li>
                    <li class="text-green-400 font-medium">Улица Летописная, 12 ✅ (правильный)</li>
                    <li>Речной вокзал</li>
                </ul>
            </div>
            <p class="text-gray-300 mb-2">
                <strong>Ответ пользователя:</strong> Площадь Свободы
            </p>
            <p class="text-red-400 font-medium mb-2">❌ Неверно</p>
            <p class="text-gray-400 text-sm">
                <strong>Время ответа:</strong> 15 апреля 2025, 10:32
            </p>
            <p class="text-gray-400 text-sm">Подсказки использовано: 2 из 3</p>
        </div>
    </div>
    <!-- Вопрос 2 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in" style="animation-delay: 0.1s;">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Вопрос 2: Кто основал город?</h3>
            <div class="space-y-2 mb-4">
                <p class="text-gray-400">Варианты ответов:</p>
                <ul class="list-disc list-inside text-gray-300 ml-4">
                    <li class="text-green-400 font-medium">Дмитрий Сосновский ✅ (правильный)</li>
                    <li>Иван Петров</li>
                    <li>Алексей Миронов</li>
                </ul>
            </div>
            <p class="text-gray-300 mb-2">
                <strong>Ответ пользователя:</strong> Дмитрий Сосновский
            </p>
            <p class="text-green-400 font-medium mb-2">✅ Верно</p>
            <p class="text-gray-400 text-sm">
                <strong>Время ответа:</strong> 15 апреля 2025, 10:37
            </p>
            <p class="text-gray-400 text-sm">Подсказки использовано: 0 из 2</p>
        </div>
    </div>
    <!-- Вопрос 3 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in" style="animation-delay: 0.2s;">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Вопрос 3: Когда был основан город?</h3>
            <p class="text-gray-300 mb-2 italic">❌ Вопрос пропущен</p>
            <p class="text-gray-400 text-sm">
                <strong>Время ответа:</strong> Не отвечено
            </p>
            <p class="text-gray-400 text-sm">Подсказки использовано: 2 из 2</p>
        </div>
    </div>
    <!-- Вопрос 4 -->
    <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 overflow-hidden animate-fade-in" style="animation-delay: 0.3s;">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-pink-300 mb-3">Вопрос 4: Как называлась первая газета города?</h3>
            <div class="space-y-2 mb-4">
                <p class="text-gray-400">Варианты ответов:</p>
                <ul class="list-disc list-inside text-gray-300 ml-4">
                    <li>"Городские Вести"</li>
                    <li>"Свет"</li>
                    <li class="text-green-400 font-medium">"Новый День" ✅ (правильный)</li>
                </ul>
            </div>
            <p class="text-gray-300 mb-2">
                <strong>Ответ пользователя:</strong> "Новый День"
            </p>
            <p class="text-green-400 font-medium mb-2">✅ Верно</p>
            <p class="text-gray-400 text-sm">
                <strong>Время ответа:</strong> 15 апреля 2025, 10:43
            </p>
            <p class="text-gray-400 text-sm">Подсказки использовано: 1 из 2</p>
        </div>
    </div>

    <!-- Итог -->
    <section class="max-w-4xl mx-auto mt-10">
        <div class="bg-black/30 backdrop-blur-md rounded-xl shadow-lg border border-white/10 p-6 text-center animate-fade-in" style="animation-delay: 0.4s;">
            <h2 class="text-2xl font-bold text-green-400 mb-2">Итог прохождения</h2>
            <p class="text-gray-300 text-lg"> Верных ответов: <span class="font-semibold">2</span> из <span class="font-semibold">3</span>
            </p>
        </div>
    </section>

    <!-- Примечание -->
    <section class="max-w-4xl mx-auto mt-8">
        <div class="bg-yellow-900/30 backdrop-blur-md rounded-xl shadow-inner border border-yellow-800/30 p-4 text-center animate-fade-in" style="animation-delay: 0.5s;">
            <p class="text-yellow-300 text-sm">
                <strong>Примечание:</strong> Определение правильности некоторых ответов может работать некорректно. 
                Мы рекомендуем руководствоваться личной честностью и внимательно проверять неочевидные вопросы.
            </p>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="max-w-4xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-sm text-gray-400"> &copy; 2025 Городской Квест Бот. Все права защищены. </footer>
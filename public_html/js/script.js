function openTab(evt, tabName) {
    const tabs = document.querySelectorAll('.tab');
    const tabButtons = document.querySelectorAll('.tab-button');

    // Скрываем все вкладки
    tabs.forEach(tab => {
        tab.classList.add('hidden');
        tab.classList.remove('active');
    });

    // Убираем активный стиль у всех кнопок
    tabButtons.forEach(btn => {
        btn.classList.remove('bg-blue-900/50', 'text-white');
        btn.classList.add('text-gray-300');
    });

    // Показываем нужную вкладку и выделяем кнопку
    document.getElementById(tabName).classList.remove('hidden');
    document.getElementById(tabName).classList.add('active');
    evt.currentTarget.classList.add('bg-blue-900/50', 'text-white');
    evt.currentTarget.classList.remove('text-gray-300');
}

// По умолчанию показываем вкладку info
window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('info').classList.add('active');
});

// Показ подсказок последовательно
function showNextHint(button) {
    const container = button.parentNode;
    const hints = container.querySelectorAll('.hint');
    let firstHidden = null;
    // Ищем первую скрытую подсказку
    for (let i = 0; i < hints.length; i++) {
        if (hints[i].classList.contains('hidden') || hints[i].style.display === 'none') {
            hints[i].style.display = 'block';
            hints[i].classList.remove('hidden');
            firstHidden = true;
            break;
        }
    }
    // Меняем текст кнопки
    const hintIndex = Array.from(hints).findIndex(h => h.classList.contains('hidden') || h.style.display === 'none');
    if (hintIndex === -1) {
        button.textContent = 'Подсказки закончились';
        button.disabled = true;
        button.style.color = '#6b7280';
        button.style.cursor = 'default';
        button.style.textDecoration = 'none';
    } else if (hintIndex === 1) {
        button.textContent = 'Показать ещё подсказку';
    }
}
// Показывает/скрывает место
function toggleLocation(button) {
    const locationBox = button.nextElementSibling;
    const isVisible = locationBox.classList.contains('hidden') || locationBox.style.display === 'none';
    locationBox.style.display = isVisible ? 'block' : 'none';
    locationBox.classList.toggle('hidden');
    button.textContent = isVisible ? 'Скрыть место' : 'Показать место';
            }
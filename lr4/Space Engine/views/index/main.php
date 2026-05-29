<div class="page-home">
    <h1>Space Engine Explorer</h1>
    <p class="page-home__subtitle">
        Ласкаво просимо у світ космосу! Досліджуйте галактики, планети та безмежний Всесвіт разом із нами.
    </p>

    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Дослідження космосу</h3>
            <p class="card__text">
                Відкрийте для себе зоряні системи, чорні діри та далекі галактики
                з детальними описами та візуалізаціями.
            </p>
        </div>

        <div class="card">
            <h3 class="card__title">Реєстрація астронавта</h3>
            <p class="card__text">
                Зареєструйтесь, щоб зберігати улюблені об'єкти,
                створювати власні маршрути подорожей та ділитися відкриттями.
            </p>
            <a href="index.php?route=regform/form" class="btn btn--small">Приєднатися</a>
        </div>

        <div class="card">
            <h3 class="card__title">Параметри місії</h3>
            <p class="card__text">
                Технічна сторінка для перегляду параметрів запиту,
                що імітують дані космічних місій.
            </p>
            <a href="index.php?route=reqview/showrequest" class="btn btn--small">Відкрити</a>
        </div>

        <div class="card">
            <h3 class="card__title">Налаштування корабля</h3>
            <p class="card__text">
                Оберіть тему інтерфейсу та налаштуйте персональне привітання
                для вашої космічної подорожі.
            </p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштувати</a>
        </div>
    </div>

    <div class="info-block">
        <h2>Архітектура космічної системи (MVC)</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Клас</th>
                    <th>Призначення</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><code>Application</code></td><td>Запуск системи та ініціація космічної місії</td></tr>
                <tr><td><code>Router</code></td><td>Навігація: визначає маршрут до потрібної "планети" (контролера)</td></tr>
                <tr><td><code>Request</code></td><td>Обробка вхідних сигналів (даних місії)</td></tr>
                <tr><td><code>Controller</code></td><td>Базовий модуль керування польотом</td></tr>
                <tr><td><code>PageController</code></td><td>Контролер для космічних сторінок/сцен</td></tr>
                <tr><td><code>View</code></td><td>Відображення інформації (інтерфейс кабіни)</td></tr>
                <tr><td><code>PageView</code></td><td>Шаблон відображення з layout (панель управління)</td></tr>
            </tbody>
        </table>
    </div>
</div>
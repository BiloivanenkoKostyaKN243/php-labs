# Виконано для лабораторної роботи №6

Проєкт у RAR був власним PHP MVC, не стандартним Laravel. Код модернізовано під вимоги Lab 6 у наявній архітектурі проєкту.

## Додано
- CRUD Products з image upload та перевіркою мінімум 100×100.
- CRUD Users з полями ПІБ, email, password hash, age, role, phone.
- CRUD Invoices з FK-логікою user/product та автоматичним розрахунком total_amount = quantity × price.
- Request-класи: StoreProductRequest, StoreUserRequest, StoreInvoiceRequest.
- Пагінація по 10 записів у Users, Products, Invoices.
- DataTables через CDN для таблиць Users, Products, Invoices.
- i18n uk/en і перемикач мови у header.
- AdminLTE-like адмін-оформлення на базі поточного UI.
- Тестову пошту при створенні User: лист зберігається у `storage/mailtrap/*.eml` як локальний Mailtrap-sandbox fallback.
- Seed admin: login/email `admin@admin.com`, password `password`, role `admin`.

## Основні маршрути
- `index.php?route=product/list`
- `index.php?route=user/list`
- `index.php?route=invoice/list`
- `index.php?route=locale/switch&lang=uk`
- `index.php?route=locale/switch&lang=en`

## Важливо
У поточному середовищі sandbox PHP не має PDO SQLite driver, тому повний runtime-тест БД тут неможливий. На локальній машині потрібно увімкнути `pdo_sqlite` або адаптувати `config/database.php` під MySQL/MariaDB.

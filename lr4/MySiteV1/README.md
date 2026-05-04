# PHP MVC Demo — Лабораторна робота №4-5

## Запуск

```bash
cd lr4/MySiteV1
php -S localhost:8080
```

Відкрити: [http://localhost:8080](http://localhost:8080)

## Маршрутизація

| URL | Сторінка |
|-----|----------|
| `index.php` | Головна |
| `index.php?route=regform/form` | Форма реєстрації |
| `index.php?route=regform/done` | Успішна реєстрація |
| `index.php?route=reqview/showrequest` | Перегляд GET/POST параметрів |
| `index.php?route=settings/color` | Колір фону (сесія) |
| `index.php?route=settings/greeting` | Привітання (cookie) |
| `index.php?route=game/menu` | Меню міні-гри |
| `index.php?route=game/play` | Ігровий екран |
| `index.php?route=game/result&system=sol` | Результат дослідження системи |
| `index.php?route=game/leaderboard` | Таблиця результатів сесії |
| `index.php?route=space` | 🚀 **Space Simulator** (NEW) |
| `index.php?route=space&seed=999` | Space Simulator (різні системи) |

## Структура

```
 MySiteV1/
├── index.php                    # Точка входу
├── generate_system.php          # API для генерації зоряних систем (NEW)
├── classes/                     # MVC-класи
│   ├── Application.php
│   ├── Router.php
│   ├── Request.php
│   ├── Controller.php
│   ├── PageController.php
│   ├── View.php
│   └── PageView.php
├── config/init.php              # Автозавантаження, сесія
├── controllers/                 # Контролери
│   ├── IndexController.php
│   ├── GameController.php
│   ├── RegformController.php
│   ├── ReqviewController.php
│   ├── SettingsController.php
│   └── SpaceController.php       # (NEW)
├── views/                       # Шаблони
│   ├── layout/
│   ├── game/
│   ├── index/
│   ├── regform/
│   ├── reqview/
│   ├── settings/
│   └── space/                   # (NEW)
│       └── main.php             # (NEW)
├── css/
│   ├── style.css
│   └── space.css                # (NEW)
├── js/
│   ├── game.js
│   └── space.js                 # (ENHANCED)
├── data/
│   └── star-systems.json
└── DOCUMENTATION FILES (NEW):
    ├── SPACE_SIMULATOR_README.md     # Повна документація
    ├── INTEGRATION_SUMMARY.md        # Огляд інтеграції
    ├── TESTING_GUIDE.md              # Керівництво тестування
    └── ARCHITECTURE.md               # Технічна архітектура
```

## Space Explorer

Модуль `Space Explorer` — це легка аркадна міні-гра з малим набором зоряних систем.
На старті дані беруться зі статичного JSON-файлу, тому пізніше їх можна безболісно
перенести у SQL-базу без зміни маршрутів сторінок.

## 🚀 Space Simulator (NEW)

Інтерактивний 3D симулятор космоса, натхненний SpaceEngine. Включає:

- **3D візуалізація**: Starfield, зірка та орбітальні планети
- **Інтерактивні елементи**: 
  - Обертання камери (ліва кнопка мишки)
  - Масштабування (коліщатко мишки)
  - Вибір планет (клік по об'єкту)
  - Інформаційна панель (HUD) з даними об'єкта
- **Процедурна генерація**: Кожна система унікальна на основі seed
- **Мобільна підтримка**: Робить на всіх пристроях

### Запуск Space Simulator
```
Головна → Карта "🚀 Space Simulator" → Запустити
Або прямо: index.php?route=space
Або з seed: index.php?route=space&seed=999
```

### Управління
| Дія | Контроль |
|-----|----------|
| Обертання | Ліва кнопка мишки + перетягування |
| Масштабування | Коліщатко мишки |
| Панування | Права кнопка мишки + перетягування |
| Вибір планети | Клік по об'єкту |
| Інформація | Обрана планета → HUD |
| Скасування | ESC або клік порожній простір |

### Документація
- **SPACE_SIMULATOR_README.md** - Повна документація
- **INTEGRATION_SUMMARY.md** - Що змінилося
- **TESTING_GUIDE.md** - Як тестувати
- **ARCHITECTURE.md** - Технічна архітектура

### Технічна інформація
- **Framework**: Three.js r128 (WebGL)
- **Controls**: OrbitControls
- **Генерація**: PHP `generate_system.php`
- **Продуктивність**: 30-60 FPS
- **Браузери**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **Мобільно**: ✅ Повна підтримка iOS і Android


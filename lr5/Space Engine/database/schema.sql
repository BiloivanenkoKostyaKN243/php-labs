-- Users table (Pilot registry)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20) DEFAULT '',
    city VARCHAR(50) DEFAULT '',
    gender VARCHAR(10) DEFAULT '',
    about TEXT DEFAULT '',
    role VARCHAR(20) NOT NULL DEFAULT 'pilot',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed demo users with roles
INSERT OR IGNORE INTO users (login, password, email, first_name, last_name, phone, city, gender, about, role) VALUES
    ('admin', '$2y$12$DqdQx4HbjRY6mA.J67ZIQeGAAYKdDsfnYMgvgzxN704ipQe2tipGC', 'admin@space.engine', 'Admin', 'Commander', '', 'Orbital Station', 'male', 'Повний доступ до керування системою.', 'admin'),
    ('pilot', '$2y$12$0H4L2oT/ByGXruHrNBAAnOvgQhl3UThQgL9FursneEYChim2GbZJS', 'pilot@space.engine', 'Pilot', 'Explorer', '', 'Mars Base', 'male', 'Звичайний користувач для роботи з модулями.', 'pilot'),
    ('viewer', '$2y$12$MTWSCruI2csLHjqOFPQjQepBq3RHWv/MxwZ87vsEb.4C.PlKvf.Zy', 'viewer@space.engine', 'Viewer', 'Observer', '', 'Lunar Outpost', 'female', 'Перегляд матеріалів без керування.', 'viewer');

-- Books table (Onboard technical blueprints and flight logs)
CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    pages INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed cosmic books
INSERT INTO books (title, author, genre, price, pages) VALUES
    ('Керівництво по експлуатації іонних двигунів X-1', 'Solaris Academy Propulsion Lab', 'Двигунобудування', 450.00, 320),
    ('Навігаційні карти та сектори туманності Андромеди', 'Kepler Exploration Agency', 'Астронавігація', 1250.50, 480),
    ('Проектування та стабілізація квантових варп-ядер', 'Dr. Alistair Vance, MIT (Mars)', 'Варп-фізика', 2100.00, 640),
    ('Системи життєзабезпечення глибокого космосу', 'United Earth Space Command', 'Космічна інженерія', 380.00, 240),
    ('Ксенобіологія: Каталог форм життя супутника Європа', 'Galactic Science Council', 'Ксенобіологія', 890.00, 510),
    ('Програмування автопілотів класу Explorer', 'Cybernetics Core Corp', 'Бортовий софт', 670.00, 390),
    ('Ремонт та обслуговування термоядерних реакторів', 'Novalight Systems Tech', 'Енергетика', 1450.00, 420),
    ('Аномалії простору-часу та чорні діри', 'Prof. Sarah Hawking, Orion Inst.', 'Астрофізика', 950.00, 580),
    ('Психологічна підготовка до міжзоряних перельотів', 'Space Health Organization', 'Медицина', 290.00, 180),
    ('Історія освоєння Сонячної Системи: 2050-2150', 'Historical Archives of Earth', 'Історія космонавтики', 540.00, 310);

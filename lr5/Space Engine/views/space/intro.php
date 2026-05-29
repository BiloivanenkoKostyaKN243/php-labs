<section class="space-intro" aria-labelledby="space-intro-title">
    <div class="space-intro__header">
        <span class="space-intro__eyebrow">Симулятор</span>
        <h1 id="space-intro-title">Space Engine <span>Simulator</span></h1>
        <p>
            Вільний політ у процедурно згенерованому космосі з фізикою корабля,
            освітленням та ефектами.
        </p>
    </div>

    <div class="controls-info">
        <h3>Керування</h3>
        <ul>
            <li><strong>W / S</strong><span>Прискорення / гальмування</span></li>
            <li><strong>A / D</strong><span>Бічне зміщення</span></li>
            <li><strong>R / F</strong><span>Вгору / вниз</span></li>
            <li><strong>Миша + ЛКМ</strong><span>Огляд та курс</span></li>
        </ul>
    </div>

    <a href="index.php?route=space/main" class="btn-launch">Запустити симулятор</a>
</section>

<style>
.space-intro {
    --intro-cyan: var(--primary, #00bcd4);
    --intro-red: var(--secondary, #cf6679);
    --intro-bg: #1a1a1e;
    --intro-panel: #202025;
    --intro-line: var(--border-color, #29292e);

    max-width: 760px;
    margin: 56px auto;
    padding: 36px;
    color: var(--text-main, #e1e1e6);
    background: var(--intro-bg);
    border: 1px solid var(--intro-line);
    border-radius: 10px;
    box-shadow: 0 14px 36px rgba(0, 0, 0, 0.28);
}

.space-intro__header {
    padding-bottom: 22px;
    border-bottom: 1px solid var(--intro-line);
}

.space-intro__eyebrow {
    display: block;
    margin-bottom: 8px;
    color: var(--intro-cyan);
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.space-intro h1 {
    margin: 0 0 12px;
    color: #fff;
    font-size: clamp(2rem, 4vw, 3rem);
    line-height: 1.1;
}

.space-intro h1 span {
    color: var(--intro-red);
}

.space-intro p {
    max-width: 620px;
    margin: 0;
    color: var(--text-muted, #8d8d99);
    font-size: 1rem;
    line-height: 1.65;
}

.controls-info {
    margin: 24px 0;
    padding: 20px;
    background: var(--intro-panel);
    border: 1px solid var(--intro-line);
    border-radius: 8px;
}

.controls-info h3 {
    margin: 0 0 12px;
    color: #fff;
    font-size: 1rem;
}

.controls-info ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.controls-info li {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--intro-line);
}

.controls-info li:last-child {
    border-bottom: 0;
}

.controls-info strong {
    color: var(--intro-red);
    font-weight: 800;
}

.controls-info span {
    color: var(--text-main, #e1e1e6);
}

.btn-launch {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 14px 22px;
    color: #fff;
    background: var(--intro-red);
    border: 0;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s ease, transform 0.2s ease;
}

.btn-launch:hover {
    color: #fff;
    background: #d83a54;
    transform: translateY(-1px);
}

@media (max-width: 760px) {
    .space-intro {
        margin: 28px 16px;
        padding: 24px;
    }

    .controls-info li {
        grid-template-columns: 1fr;
        gap: 4px;
    }
}
</style>

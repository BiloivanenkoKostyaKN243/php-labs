<div class="space-intro">
    <h1>Space Engine <span>Simulator</span></h1>
    <p>Ласкаво просимо до симулятора вільного польоту. Досліджуйте процедурно згенеровані зіркові системи з реалістичною фізикою корабля, освітленням та ефектами.</p>
    
    <div class="controls-info">
        <h3>Управління кораблем:</h3>
        <ul>
            <li><strong>W / S</strong> — Прискорення / Гальмування (Маршеві двигуни)</li>
            <li><strong>A / D</strong> — Бічне зміщення (Стрейф)</li>
            <li><strong>R / F</strong> — Вертикальне зміщення (Вгору / Вниз)</li>
            <li><strong>Миша (Затиснути ліву кнопку)</strong> — Обертання камери / Керування курсом</li>
        </ul>
    </div>

    <a href="index.php?route=space/main" class="btn-launch">🚀 Запустити Симулятор</a>
</div>

<style>
.space-intro {
    max-width: 800px;
    margin: 40px auto;
    background: #1a1a2e;
    color: #e0e0e0;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    border: 1px solid #16213e;
}
.space-intro h1 {
    color: #4ddbff;
    margin-top: 0;
    font-size: 2.5rem;
    border-bottom: 2px solid #0f3460;
    padding-bottom: 15px;
}
.space-intro h1 span { color: #e94560; }
.space-intro p { font-size: 1.1rem; line-height: 1.6; }
.controls-info {
    background: #0f3460;
    padding: 20px;
    border-radius: 8px;
    margin: 30px 0;
}
.controls-info h3 { margin-top: 0; color: #fff; }
.controls-info ul { list-style: none; padding: 0; }
.controls-info li { padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
.controls-info li:last-child { border-bottom: none; }
.controls-info strong { color: #e94560; }
.btn-launch {
    display: block;
    text-align: center;
    background: #e94560;
    color: white;
    text-decoration: none;
    font-size: 1.3rem;
    font-weight: bold;
    padding: 15px 30px;
    border-radius: 8px;
    transition: background 0.3s;
}
.btn-launch:hover { background: #d83a54; }
</style>

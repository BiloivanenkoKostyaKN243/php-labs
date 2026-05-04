(function () {
    var app = document.getElementById('game-app');
    var dataNode = document.getElementById('game-systems-data');
    var canvas = document.getElementById('game-canvas');

    if (!app || !dataNode || !canvas) {
        return;
    }

    var systems = [];

    try {
        systems = JSON.parse(dataNode.textContent || '[]');
    } catch (error) {
        systems = [];
    }

    if (!Array.isArray(systems) || systems.length === 0) {
        return;
    }

    var selectedId = app.getAttribute('data-selected-system') || '';
    var selectedIndex = systems.findIndex(function (system) {
        return system.id === selectedId;
    });

    if (selectedIndex < 0) {
        selectedIndex = 0;
    }

    var ctx = canvas.getContext('2d');

    if (!ctx) {
        return;
    }

    var previousButton = document.getElementById('game-prev-button');
    var nextButton = document.getElementById('game-next-button');
    var exploreButton = document.getElementById('game-explore-button');
    var systemList = document.getElementById('game-system-list');
    var nameNode = document.getElementById('game-system-name');
    var descriptionNode = document.getElementById('game-system-description');
    var starTypeNode = document.getElementById('game-star-type');
    var distanceNode = document.getElementById('game-distance');
    var planetCountNode = document.getElementById('game-planet-count');
    var dangerNode = document.getElementById('game-danger');
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var logicalWidth = 900;
    var logicalHeight = 520;
    var stars = Array.from({ length: 90 }, function () {
        return {
            x: Math.random(),
            y: Math.random(),
            size: Math.random() * 2 + 0.4,
            alpha: Math.random() * 0.8 + 0.2,
            speed: Math.random() * 0.008 + 0.002
        };
    });
    var angle = 0;

    function resizeCanvas() {
        var maxWidth = canvas.parentElement ? canvas.parentElement.clientWidth : logicalWidth;
        var width = Math.min(maxWidth, logicalWidth);
        var height = Math.round(width * (logicalHeight / logicalWidth));

        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function getCurrentSystem() {
        return systems[selectedIndex] || systems[0];
    }

    function formatDistance(value) {
        return Number(value || 0).toFixed(2) + ' св. років';
    }

    function renderSystemList() {
        if (!systemList) {
            return;
        }

        systemList.innerHTML = '';

        systems.forEach(function (system, index) {
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'game-system-button' + (index === selectedIndex ? ' game-system-button--active' : '');
            button.textContent = system.name + ' · ' + Number(system.distance || 0).toFixed(2) + ' св. р.';
            button.addEventListener('click', function () {
                selectedIndex = index;
                updateUI();
            });
            systemList.appendChild(button);
        });
    }

    function updateUI() {
        var system = getCurrentSystem();
        var planets = Array.isArray(system.planets) ? system.planets : [];

        if (nameNode) {
            nameNode.textContent = system.name || 'Невідома система';
        }

        if (descriptionNode) {
            descriptionNode.textContent = 'У системі ' + (system.name || 'без назви') + ' знайдено ' + planets.length + ' планет. Виберіть її для перегляду підсумку експедиції.';
        }

        if (starTypeNode) {
            starTypeNode.textContent = system.starType || 'Невідомо';
        }

        if (distanceNode) {
            distanceNode.textContent = formatDistance(system.distance);
        }

        if (planetCountNode) {
            planetCountNode.textContent = String(planets.length);
        }

        if (dangerNode) {
            dangerNode.textContent = String(Number(system.danger || 0)) + '/5';
        }

        if (exploreButton) {
            exploreButton.setAttribute('href', 'index.php?route=game/result&system=' + encodeURIComponent(system.id || ''));
        }

        app.setAttribute('data-selected-system', system.id || '');
        renderSystemList();
    }

    function drawBackground(width, height) {
        var gradient = ctx.createLinearGradient(0, 0, 0, height);
        gradient.addColorStop(0, '#0f172a');
        gradient.addColorStop(1, '#020617');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);

        stars.forEach(function (star) {
            star.alpha += Math.sin(angle * star.speed * 14) * 0.002;
            ctx.globalAlpha = Math.max(0.15, Math.min(1, star.alpha));
            ctx.fillStyle = '#f8fafc';
            ctx.beginPath();
            ctx.arc(star.x * width, star.y * height, star.size, 0, Math.PI * 2);
            ctx.fill();
        });

        ctx.globalAlpha = 1;
    }

    function drawSystem() {
        var width = canvas.clientWidth;
        var height = canvas.clientHeight;
        var system = getCurrentSystem();
        var planets = Array.isArray(system.planets) ? system.planets : [];
        var centerX = width * 0.42;
        var centerY = height * 0.52;
        var starRadius = 24 + Number(system.danger || 0) * 3;

        drawBackground(width, height);

        var starGlow = ctx.createRadialGradient(centerX, centerY, 10, centerX, centerY, 100);
        starGlow.addColorStop(0, 'rgba(250, 204, 21, 0.95)');
        starGlow.addColorStop(1, 'rgba(250, 204, 21, 0)');
        ctx.fillStyle = starGlow;
        ctx.beginPath();
        ctx.arc(centerX, centerY, 100, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#fde68a';
        ctx.beginPath();
        ctx.arc(centerX, centerY, starRadius, 0, Math.PI * 2);
        ctx.fill();

        planets.forEach(function (planet, index) {
            var orbitRadius = 70 + index * 50;
            var orbitAngle = angle * (0.35 + index * 0.1) + index;
            var px = centerX + Math.cos(orbitAngle) * orbitRadius;
            var py = centerY + Math.sin(orbitAngle) * (orbitRadius * 0.45);
            var habitability = Number(planet.habitability || 0);
            var planetRadius = 6 + Math.max(0, Math.min(10, habitability / 20));
            var hue = Math.round(200 - Math.min(120, habitability));

            ctx.strokeStyle = 'rgba(148, 163, 184, 0.28)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.ellipse(centerX, centerY, orbitRadius, orbitRadius * 0.45, 0, 0, Math.PI * 2);
            ctx.stroke();

            ctx.fillStyle = 'hsl(' + hue + ', 80%, 65%)';
            ctx.beginPath();
            ctx.arc(px, py, planetRadius, 0, Math.PI * 2);
            ctx.fill();

            ctx.fillStyle = 'rgba(226, 232, 240, 0.9)';
            ctx.font = '13px Segoe UI';
            ctx.fillText(String(planet.name || ''), px + planetRadius + 8, py + 4);
        });

        ctx.fillStyle = '#e2e8f0';
        ctx.font = '600 16px Segoe UI';
        ctx.fillText(system.name || 'Невідома система', 24, 34);
        ctx.font = '14px Segoe UI';
        ctx.fillStyle = '#93c5fd';
        ctx.fillText((system.starType || 'Невідомо') + ' · ' + formatDistance(system.distance), 24, 58);
    }

    function tick() {
        angle += 0.01;
        drawSystem();
        window.requestAnimationFrame(tick);
    }

    if (previousButton) {
        previousButton.addEventListener('click', function () {
            selectedIndex = (selectedIndex - 1 + systems.length) % systems.length;
            updateUI();
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            selectedIndex = (selectedIndex + 1) % systems.length;
            updateUI();
        });
    }

    window.addEventListener('resize', function () {
        resizeCanvas();
        drawSystem();
    });

    resizeCanvas();
    updateUI();
    tick();
})();


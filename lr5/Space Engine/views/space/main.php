<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Engine - Simulator</title>
    <link rel="stylesheet" href="css/space.css">
</head>
<body>

    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="spinner"></div>
        <div class="loading-text">ІНІЦІАЛІЗАЦІЯ СИСТЕМИ... <span id="loading-progress">0%</span></div>
    </div>

    <!-- UI Overlay (HUD) -->
    <div id="ui-layer" class="ui-layer">
        <!-- Приціл -->
        <div class="crosshair"></div>

        <!-- Відлагодження / Інфо -->
        <div class="debug-panel">
            <div class="debug-item">FPS: <span id="ui-fps">0</span></div>
            <div class="debug-item">POS: <span id="ui-pos">0, 0, 0</span></div>
        </div>

        <!-- Спідометр та стан корабля -->
        <div class="ship-status">
            <div class="speed-container">
                ШВИДКІСТЬ: <span id="ui-speed">0</span> KM/S
                <div class="speed-bar-bg"><div id="ui-speed-bar" class="speed-bar-fill"></div></div>
            </div>
            <div class="target-info hidden" id="ui-target-panel">
                ОБ'ЄКТ: <span id="ui-target-name">-</span><br>
                ВІДСТАНЬ: <span id="ui-target-dist">0</span> KM
            </div>
        </div>

        <!-- Кнопка виходу -->
        <button id="btn-exit" class="btn-exit">← ПОВЕРНУТИСЬ</button>
    </div>

    <!-- WebGL Canvas -->
    <div id="space-canvas" class="space-canvas"></div>

    <!-- Core Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- Effect Composer (Post-processing) -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/EffectComposer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/RenderPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/ShaderPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/shaders/CopyShader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/shaders/LuminosityHighPassShader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/UnrealBloomPass.js"></script>
    <!-- Procedural Noise for Textures -->
    <script src="https://cdn.jsdelivr.net/npm/simplex-noise@2.4.0/simplex-noise.min.js"></script>

    <!-- Game Modules -->
    <script src="js/space/ui.js"></script>
    <script src="js/space/controls.js"></script>
    <script src="js/space/objects.js"></script>
    <script src="js/space/scene.js"></script>
    <script src="js/space/main.js"></script>

</body>
</html>

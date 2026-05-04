<?php
// Полностью независимая страница Space Engine - Обновленная
header('Content-Type: text/html; charset=utf-8');
$seed = (int)($_GET['seed'] ?? mt_rand(1000, 99999));
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Explorer — Interactive Web Game</title>
    <link rel="stylesheet" href="css/space.css">
    <style>
        body { margin: 0; overflow: hidden; background: #000; }
        /* Reset any conflicting styles for standalone mode */
        main { display: block; height: 100vh; }
    </style>
</head>
<body>
    <main class="main--space">
        <div id="space-canvas" class="space-container"></div>
    </main>

    <!-- Three.js Core -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/FlyControls.js"></script>

    <!-- Three.js Post-Processing (Bloom) -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/EffectComposer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/RenderPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/ShaderPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/shaders/CopyShader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/shaders/LuminosityHighPassShader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/postprocessing/UnrealBloomPass.js"></script>

    <!-- Space Simulator Logic -->
    <script src="js/space.js"></script>
</body>
</html>

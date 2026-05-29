<?php
// Спрощена сторінка Space Engine
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спрощений Space Explorer</title>
    <link rel="stylesheet" href="css/space.css">
</head>
<body>
    <div id="space-canvas"></div>

    <!-- Three.js Core та прості контроли (OrbitControls замість складного FlyControls) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <!-- Спрощена логіка -->
    <script src="js/space.js"></script>
</body>
</html>

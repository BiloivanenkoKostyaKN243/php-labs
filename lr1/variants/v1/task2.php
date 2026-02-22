<?php

require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="poem">
    <?php
    echo "<p class='poem-indent-1'>Полину в мріях в купель океану,</p>";
    echo "<p class='poem-indent-1'>Відчую <b>шовковистість</b> глибини,</p>";
    echo "<p class='poem-indent-1'>Чарівні мушлі з дна собі дістану,</p>";
    echo "<p style='margin-left: 50px' class='poem-indent-1'>Щоб взимку</p>";
    echo "<p style='margin-left: 70px' class='poem-indent-1'>тішили</p>";
    echo "<p style='margin-left: 90px' class='poem-indent-1'>мене</p>";
    echo "<p style='margin-left: 110px' class='poem-indent-1'>вони...</p>";
    ?>
</div>
<?php
$content = ob_get_clean();

renderVariantLayout($content, 'Завдання 1', 'task2-body');

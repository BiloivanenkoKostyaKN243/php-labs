<?php

require_once __DIR__ . '/layout.php';

function generateRandomSquares(int $n): string
{
    $html = "<div class='shapes-container shapes-container--black'>";


    for ($i = 0; $i < $n; $i++)
    {

        $size = mt_rand(30, 100);

        $top = mt_rand(5, 85);

        $left = mt_rand(5, 85);

        $opacity = mt_rand(70, 100) / 100;



        $html .= "

        <div style='

            position:absolute;

            top:{$top}%;

            left:{$left}%;

            width:{$size}px;

            height:{$size}px;

            background:#ef4444;

            opacity:{$opacity};

        '>

        </div>

        ";
    }


    $html .= "</div>";

    return $html;
}

$n = 10;



$squares = generateRandomSquares($n);

$content =

    $squares .

    '

<div class="circles-func">

    generateRandomSquares(' . $n . ')

</div>


<div class="circles-counter">

    🟥 Квадратів: ' . $n . '

</div>


<p class="circles-info">

    Оновіть сторінку для нової композиції 🔄

</p>

';


renderVariantLayout(

    $content,

    'Завдання 7.2',

    'task7-squares-body'

);
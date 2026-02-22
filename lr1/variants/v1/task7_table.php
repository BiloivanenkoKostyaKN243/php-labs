<?php

require_once __DIR__ . '/layout.php';

function generateColorTable(int $rows, int $cols): string
{
    $html = "<table class='chessboard'>";

    for ($i = 0; $i < $rows; $i++)
    {
        $html .= "<tr>";

        for ($j = 0; $j < $cols; $j++)
        {
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

            $html .= "

            <td style='

                background-color: {$color};

                width: 50px;

                height: 50px;

            '>

            </td>

            ";
        }

        $html .= "</tr>";
    }

    $html .= "</table>";

    return $html;
}

$rows = 8;
$cols = 8;



$table = generateColorTable($rows, $cols);

$content = '

<h1>

    🎨 Таблиця ' . $rows . ' × ' . $cols . '

</h1>


<div class="params">

    generateColorTable(' . $rows . ', ' . $cols . ')

</div>


' . $table;

renderVariantLayout(

    $content,

    'Завдання 7.1',

    'task7-table-body'

);
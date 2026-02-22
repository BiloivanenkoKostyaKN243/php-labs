<?php


require_once __DIR__ . '/layout.php';

function sumOfDigits(int $number): int
{
    $d1 = (int) floor($number / 100);
    $d2 = (int) floor(($number % 100) / 10);
    $d3 = $number % 10;

    return $d1 + $d2 + $d3;
}


function reverseNumber(int $number): int
{
    $d1 = (int) floor($number / 100);
    $d2 = (int) floor(($number % 100) / 10);
    $d3 = $number % 10;

    return $d3 * 100 + $d2 * 10 + $d1;
}


function maxPossibleNumber(int $number): int
{
    $digits = [

        (int) floor($number / 100),
        (int) floor(($number % 100) / 10),
        $number % 10

    ];

    rsort($digits);

    return $digits[0] * 100 + $digits[1] * 10 + $digits[2];
}

$number = 581;



$d1 = (int)($number / 100);
$d2 = (int)(($number % 100) / 10);
$d3 = $number % 10;



$sum = sumOfDigits($number);

$reversed = reverseNumber($number);

$maxNumber = maxPossibleNumber($number);

$content = '

<div class="task6-container">


    <div class="card">

        <h3>🔢 Тризначне число</h3>


        <div class="number-display">

            ' . $number . '

        </div>


        <div class="digits-row">

            <div class="digit-box">' . $d1 . '</div>

            <div class="digit-box">' . $d2 . '</div>

            <div class="digit-box">' . $d3 . '</div>

        </div>

    </div>




    <div class="card mt-20">

        <h3>📊 Результати</h3>


        <div class="result-row">

            <div>

                <span>1. Сума цифр</span>

                <div class="func">

                    sumOfDigits(' . $number . ')

                </div>

            </div>


            <span class="result-value">

                ' . $sum . '

            </span>

        </div>




        <div class="result-row">

            <div>

                <span>2. Зворотне число</span>

                <div class="func">

                    reverseNumber(' . $number . ')

                </div>

            </div>


            <span class="result-value">

                ' . $reversed . '

            </span>

        </div>




        <div class="result-row">

            <div>

                <span>3. Найбільше можливе число</span>

                <div class="func">

                    maxPossibleNumber(' . $number . ')

                </div>

            </div>


            <span class="result-value">

                ' . $maxNumber . '

            </span>

        </div>



    </div>

</div>

';


renderVariantLayout(

    $content,

    'Завдання 6',

    'task6-body'

);
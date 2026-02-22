<?php

require_once __DIR__ . '/layout.php';

function convertUahToUsd(float $uah, float $rate): float
{
    return round($uah / $rate, 2);
}

function applyCommission(float $amount, float $commissionPercent): float
{
    return round($amount * (1 - $commissionPercent / 100), 2);
}


$uah = 1500;
$rate = 29.50;
$commission = 2;

$usdBeforeCommission = convertUahToUsd($uah, $rate);
$usdAfterCommission = applyCommission($usdBeforeCommission, $commission);

$content = '<div class="card">
    <h2>💵 Конвертер UAH → USD</h2>

    <p><strong>Курс:</strong> 1 USD = ' . $rate . ' грн</p>

    <p><strong>Комісія банку:</strong> ' . $commission . '%</p>

    <div class="result">
        ' . $uah . ' грн = ' . $usdBeforeCommission . ' доларів
    </div>

    <div class="result mt-10 result-commission">
        Після комісії ' . $commission . '% —
        <strong>' . $usdAfterCommission . '</strong> доларів
    </div>

    <p class="info">
        convertUahToUsd(' . $uah . ', ' . $rate . ') = ' . $usdBeforeCommission . '
    </p>

    <p class="info">
        applyCommission(' . $usdBeforeCommission . ', ' . $commission . ') = ' . $usdAfterCommission . '
    </p>

</div>';

renderVariantLayout($content, 'Завдання 3', 'task3-body');
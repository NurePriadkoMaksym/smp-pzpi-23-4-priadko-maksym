<?php

$items = [
    1 => ["title" => "Молоко пастеризоване", "cost" => 12],
    2 => ["title" => "Хліб чорний         ", "cost" => 9],
    3 => ["title" => "Сир білий           ", "cost" => 21],
    4 => ["title" => "Сметана 20%         ", "cost" => 25],
    5 => ["title" => "Кефір 1%            ", "cost" => 19],
    6 => ["title" => "Вода газована       ", "cost" => 18],
    7 => ["title" => "Печиво \"Весна\"      ", "cost" => 14],
];

$basket = [];
$clientName = "";
$clientAge = 0;

function displayMenu() {
    echo "\n==============================\n";
    echo "= ЛАСКАВО ПРОСИМО ДО МАГАЗИНУ =\n";
    echo "=========== ВЕСНА ============\n";
    echo "1. Переглянути товари\n";
    echo "2. Перевірити кошик\n";
    echo "3. Змінити інформацію про клієнта\n";
    echo "0. Завершити роботу\n";
    echo "Оберіть опцію: ";
}

function displayItems($items) {
    echo "№  НАЗВА                   ЦІНА\n";
    foreach ($items as $key => $val) {
        printf("%-2d %-24s %5d\n", $key, $val["title"], $val["cost"]);
    }
    echo "   ------------------------------\n";
    echo "0  ПОВЕРНЕННЯ ДО МЕНЮ\n";
    echo "Оберіть товар: ";
}

function showBasket($basket) {
    if (count($basket) === 0) {
        echo "ВАШ КОШИК ПОРОЖНІЙ\n";
        return;
    }
    echo "КОРЗИНА:\nНАЗВА                   КІЛЬКІСТЬ\n";
    foreach ($basket as $name => $amount) {
        printf("%-24s %5d\n", $name, $amount);
    }
}

function inputLine() {
    return trim(fgets(STDIN));
}

while (true) {
    displayMenu();
    $input = inputLine();

    switch ($input) {
        case "1":
            while (true) {
                displayItems($items);
                $sel = inputLine();
                if ($sel === "0") break;

                if (!isset($items[$sel])) {
                    echo "ПОМИЛКА: Невірний номер товару.\n";
                    continue;
                }

                $chosenName = $items[$sel]["title"];
                echo "Обрано: {$chosenName}\n";
                echo "Введіть кількість (шт.): ";
                $amount = inputLine();

                if (!is_numeric($amount) || $amount < 0) {
                    echo "ПОМИЛКА: Кількість має бути числом >= 0.\n";
                    continue;
                }

                if ($amount == 0) {
                    echo "Товар видалено з кошика.\n";
                    unset($basket[$chosenName]);
                } else {
                    $basket[$chosenName] = $amount;
                }

                showBasket($basket);
            }
            break;

        case "2":
            if (empty($basket)) {
                echo "Кошик наразі порожній.\n";
                break;
            }

            echo "№  НАЗВА                   ЦІНА   КІЛЬК.  СУМА\n";
            echo "--------------------------------------------------\n";
            $idx = 1;
            $grandTotal = 0;
            foreach ($basket as $title => $qty) {
                $unitCost = 0;
                foreach ($items as $entry) {
                    if ($entry["title"] == $title) {
                        $unitCost = $entry["cost"];
                        break;
                    }
                }
                $subTotal = $unitCost * $qty;
                printf("%-2d %-24s %6d %6d %8d\n", $idx++, $title, $unitCost, $qty, $subTotal);
                $grandTotal += $subTotal;
            }
            echo "--------------------------------------------------\n";
            echo "ЗАГАЛОМ ДО СПЛАТИ: {$grandTotal}\n";
            break;

        case "3":
            do {
                echo "Введіть ваше ім'я: ";
                $clientName = inputLine();
            } while (!preg_match('/[a-zA-Zа-яА-ЯіІїЇєЄ]/u', $clientName));

            do {
                echo "Вкажіть ваш вік: ";
                $clientAge = inputLine();
            } while (!is_numeric($clientAge) || $clientAge < 7 || $clientAge > 150);

            echo "Профіль оновлено: {$clientName}, вік {$clientAge}\n";
            break;

        case "0":
            echo "Дякуємо за візит до \"Весна\"! Гарного дня!\n";
            exit;

        default:
            echo "ПОМИЛКА: Оберіть коректну опцію з меню.\n";
            break;
    }
}

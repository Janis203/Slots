<?php
$symbols = ["*", "+", "O", "O", "X", "X", "X", "A", "A", "A"];
$coins = (int)readline("Enter coins: ");
if ($coins < 5) {
    exit ("Insufficient amount");
}
$rows = (int)readline("Enter row amount: ");
if ($rows < 3) {
    exit ("Too small");
}
$columns = (int)readline("Enter columns: ");
if ($columns < 3) {
    exit ("Too small");
}
while (true) {
    $betAmount = (int)readline("Enter bet: ");
    if ($betAmount < 5 || $betAmount > $coins) {
        echo "Wrong bet amount" . PHP_EOL;
        continue;
    }
    $gameField = [];
    echo str_repeat("___", $columns) . PHP_EOL;
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $gameField[$i][$j] = $symbols[array_rand($symbols)];
            echo "|" . $gameField[$i][$j] . "|";
        }
        echo "\n" . str_repeat("---", $columns) . PHP_EOL;
    }

    $combo = 0;
    $winSymbols = [];
    for ($i = 0; $i < $rows; $i++) {
        $combo = 0;
        for ($j = 1; $j < $columns; $j++) {
            if ($gameField[$i][$j] === $gameField[$i][$j - 1]) {
                $combo++;
            }
        }
        if ($combo === $columns - 1) {
            $winSymbols[] = $gameField[$i][0];
        }
    }
    $combo = 0;
    $rowNr = 1;
    $previousSymbol = $gameField[0][0];
    for ($i = 1; $i < $columns; $i++) {
        if ($gameField[$rowNr][$i] !== $previousSymbol) {
            break;
        }
        $combo++;
        if ($rowNr < $rows - 1) {
            $rowNr++;
        }
        $previousSymbol = $gameField[$rowNr][$i];
    }
    if ($combo === $columns - 1) {
        $winSymbols[] = $gameField[0][0];
    }
    $combo = 0;
    $rowNr = $rows - 1;
    $previousSymbol = $gameField[$rowNr][0];
    for ($i = 1; $i < $columns; $i++) {
        if ($gameField[$rowNr][$i] !== $previousSymbol) {
            break;
        }
        $combo++;
        if ($rowNr > 0) {
            $rowNr--;
        }
        $previousSymbol = $gameField[$rowNr][$i];
    }
    if ($combo === $columns - 1) {
        $winSymbols[] = $gameField[$rows - 1][0];
    }
    if (count($winSymbols) > 0) {
        foreach ($winSymbols as $symbol) {
            switch ($symbol) {
                case "*":
                    echo "You won " . (($betAmount + 5) * 5) . " coins!" . PHP_EOL;
                    $coins += ($betAmount + 5) * 5;
                    break;
                case "+":
                    echo "You won " . (($betAmount + 4) * 3) . " coins!" . PHP_EOL;
                    $coins += ($betAmount + 4) * 3;
                    break;
                case "O":
                    echo "You won " . (($betAmount + 3) * 2) . " coins!" . PHP_EOL;
                    $coins += ($betAmount + 3) * 2;
                    break;
                case "X":
                    echo "You won " . ($betAmount * 2) . " coins!" . PHP_EOL;
                    $coins += $betAmount * 2;
                    break;
                case "A":
                    echo "You won $betAmount coins!" . PHP_EOL;
                    $coins += $betAmount;
                    break;
            }
        }
    } else {
        $coins -= $betAmount;
        echo "You lost! $coins coins left" . PHP_EOL;
    }
    if ($coins < 5) {
        exit ("Insufficient amount. You have $coins coins");
    }
    $userChoice = strtolower(readline("Continue?(yes/no) "));
    if ($userChoice === "yes" || $userChoice === "y") {
        echo "You have $coins coins left" . PHP_EOL;
    } elseif ($userChoice === "no" || $userChoice === "n") {
        exit("You got $coins coins!");
    } else {
        echo "Wrong input";
        break;
    }
}
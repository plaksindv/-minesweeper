<?php namespace plaksindv\minesweeper\Controller;

use function plaksindv\minesweeper\View\showGame;

use function plaksindv\minesweeper\FieldCreator\createCellsArray;

use function plaksindv\minesweeper\InGame\openArea;
use function plaksindv\minesweeper\InGame\isBomb;
use function plaksindv\minesweeper\InGame\setFlag;

function printArray($array1)
{
    for ($i = 0; $i < count($array1); $i++) {
        \cli\line($array1[$i]['x'] . ' ' . $array1[$i]['y']);
    }

    // for ($i = 0; $i < MAX_Y; $i++) {
    //     for ($j = 0; $j < MAX_X; $j++) {
    //         \cli\line($array2[$i][$j]['opened'] . ' ' . $array2[$i][$j]['marked'] . ' ' . $array2[$i][$j]['isbomb'] . ' ' . $array2[$i][$j]['nearbycount']);
    //     }
    // }
}

function startGame() 
{
    global $bombsArray, $cellsArray, $lostGame, $openedCellsCount;
    createCellsArray();
    showGame();
    for ($i = 0; $i < count($bombsArray); $i++) {
        setFlag($bombsArray[$i]['x'], $bombsArray[$i]['y']);
    }
    while ($lostGame == false) {
        \cli\line($openedCellsCount);
        printArray($bombsArray);
        
        $inputString = \cli\prompt(
            "Введите координаты x, y ячейки через " 
            . "запятую без пробела, если хотите "
            . "установить флаг в ячейку, то введите " 
            . "F после координат"
        );
        $inputArray = explode(',', $inputString);

        
        if (isset($inputArray[2]) 
            && ($inputArray[2] == 'F' || $inputArray[2] == 'f')
        ) {
            setFlag($inputArray[0], $inputArray[1]);
        } else {
            if (isBomb($inputArray[0], $inputArray[1])) {
                \cli\prompt("GAME LOST");
                break;
            } else {
                if ($openedCellsCount == count($cellsArray) * count($cellsArray[0])) {
                    \cli\prompt("GAME WON");
                    break;
                } else {
                    openArea($inputArray[0], $inputArray[1]);
                }
            }
        }
        \cli\line("---------");
        showGame();
    }
}
?>
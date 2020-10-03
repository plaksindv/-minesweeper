<?php

namespace plaksindv\minesweeper\Controller;

use function plaksindv\minesweeper\View\showGame;
use function plaksindv\minesweeper\FieldCreator\createCellsArray;
use function plaksindv\minesweeper\InGame\openArea;
use function plaksindv\minesweeper\InGame\isBomb;
use function plaksindv\minesweeper\InGame\setFlag;

function createVars()
{
    define("MAX_X", 10);
    define("MAX_Y", 10);
    define("BOMBS_COUNT", 10);

    $cellsArray = array();
    $bombsArray = array();
    $openedCellsCount = 0;
}

function gameLoop()
{
    global $cellsArray, $lostGame, $openedCellsCount;
    $turnCount = 1;
    while (true) {
        showGame($turnCount);
        $turnCount++;
        
        $inputString = \cli\prompt(
            "Введите координаты x, y ячейки через "
            . "запятую без пробела.\nЕсли хотите "
            . "установить флаг в ячейку, то введите "
            . "F после ввода координат"
        );
        $inputArray = explode(',', $inputString);

        if (
            isset($inputArray[2])
            && ($inputArray[2] == 'F' || $inputArray[2] == 'f')
        ) {
            setFlag($inputArray[0], $inputArray[1]);
        } else {
            if (isBomb($inputArray[0], $inputArray[1])) {
                showGame($turnCount);
                \cli\line("GAME OVER");
                break;
            } else {
                if ($openedCellsCount == count($cellsArray) * count($cellsArray[0])) {
                    showGame($turnCount);
                    \cli\line("YOU WON");
                    break;
                }
                openArea($inputArray[0], $inputArray[1]); 
            }
        }
    }
}

function startGame()
{
    createVars();
    createCellsArray();
    gameLoop();
}

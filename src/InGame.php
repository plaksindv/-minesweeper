<?php

namespace plaksindv\minesweeper\InGame;

function openSurroundedCells($x, $y)
{
    global $cellsArray;
    if (
        isset($cellsArray[$y])
        && isset($cellsArray[$y][$x])
    ) {
        openArea($x, $y);
    }
}

function isBomb($x, $y)
{
    global $cellsArray, $lostGame;
    if (
        $cellsArray[$y][$x]['isbomb'] == true
        && $cellsArray[$y][$x]['marked'] == false
    ) {
        $cellsArray[$y][$x]['opened'] = true;
        return true;
    }
    return false;
}

function openArea($x, $y)
{
    global $openedCellsCount, $cellsArray;
    if (
        $cellsArray[$y][$x]['opened'] == false
        && $cellsArray[$y][$x]['marked'] == false
    ) {
        $cellsArray[$y][$x]['opened'] = true;
        $openedCellsCount += 1;
        if ($cellsArray[$y][$x]['nearbycount'] != 0) {
            return;
        }
    } else {
        return;
    }
    for ($i = $x - 1; $i <= $x + 1; $i++) {
        for ($j = $y - 1; $j <= $y + 1; $j++) {
            openSurroundedCells($i, $j);
        }
    }
}

function setFlag($x, $y)
{
    global $openedCellsCount, $cellsArray;
    if ($cellsArray[$y][$x]['marked'] == false) {
        if ($cellsArray[$y][$x]['opened'] == false) {
            $cellsArray[$y][$x]['marked'] = true;
            $cellsArray[$y][$x]['opened'] = true;
            $openedCellsCount++;
        }
    } else {
            $cellsArray[$y][$x]['marked'] = false;
            $cellsArray[$y][$x]['opened'] = false;
            $openedCellsCount--;
    }
}

<?php namespace plaksindv\minesweeper\Controller;
    use function plaksindv\minesweeper\View\showGame;
    
    function startGame() {
        echo "Game started".PHP_EOL;
        showGame();
    }
?>
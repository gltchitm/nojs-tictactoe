<?php
    if (basename($_SERVER["PHP_SELF"]) === basename(__FILE__)) {
        header("Location: /");
        exit;
    }
?>
<style>
    #main-menu {
        display: none;
    }
</style>
<div class="jumbotron">
    <h1>NoJS TicTacToe</h1>
    <p>
        This implementation uses absolutely <strong>no</strong> JavaScript.
        Everything is done 100% server-side!
    </p>
    <a class="btn btn-primary" href="select_type">Start Game</a>
</div>
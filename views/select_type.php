<?php
    if (basename($_SERVER["PHP_SELF"]) === basename(__FILE__)) {
        header("Location: /");
        exit;
    }
?>
<div class="jumbotron">
    <h1>NoJS TicTacToe</h1>
    <p>Select game type.</p>
    <a
        class="btn btn-primary"
        href="vs_friend?gameboard=---------&turn=X&winner=-"
    >
        Vs Friend
    </a>
    <a
        class="btn btn-primary"
        href="vs_computer?gameboard=---------&turn=X&winner=-"
    >
        Vs Computer
    </a>
</div>
<?php
    if (basename($_SERVER["PHP_SELF"]) === basename(__FILE__)) {
        header("Location: /");
        exit;
    }
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="/" class="navbar-brand">NoJS TicTacToe</a>
        <a href="/" class="btn btn-outline-primary" id="main-menu">
            Back to Main Menu
        </a>
    </div>
</nav>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="static/bootstrap.min.css" />
        <link rel="stylesheet" href="static/styles.css" />
        <title>NoJS TicTacToe</title>
    </head>
    <body>
        <?php include("views/partials/navbar.php") ?>
        <div class="container">
            <?php
                function is_valid_gameboard($gameboard) {
                    return (
                        strlen($gameboard) === 9 &&
                        strlen(preg_replace("/[XO-]/", "", $gameboard)) == 0
                    );
                }
                $request_uri = explode("?", $_SERVER["REQUEST_URI"], 2);
                if ($request_uri[0] === "/select_type") {
                    include("views/select_type.php");
                } else if (
                    (
                        $request_uri[0] === "/vs_friend" ||
                        $request_uri[0] === "/vs_computer"
                    ) &&
                    isset($_GET["gameboard"]) &&
                    isset($_GET["turn"]) &&
                    isset($_GET["winner"]) &&
                    is_valid_gameboard($_GET["gameboard"]) &&
                    (
                        $_GET["turn"] === "X" ||
                        $_GET["turn"] === "O"
                    ) &&
                    (
                        $_GET["winner"] === "-" ||
                        $_GET["winner"] === "X" ||
                        $_GET["winner"] === "O" ||
                        $_GET["winner"] === "TIE"
                    )
                ) {
                    $vs_friend = $request_uri[0] === "/vs_friend";
                    $gameboard = $_GET["gameboard"];
                    $turn = $_GET["turn"];
                    $winner = $_GET["winner"];
                    include("views/game.php");
                } else {
                    include("views/welcome.php");
                }
            ?>
        </div>
    </body>
</html>

<?php
    if (basename($_SERVER["PHP_SELF"]) === basename(__FILE__)) {
        header("Location: /");
        exit;
    }
    const WINNING_PATTERNS = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];
    function get_cell($index) {
        global $gameboard;
        if ($gameboard[$index] === "-") {
            return "&nbsp;";
        } else {
            return $gameboard[$index];
        }
    }
    function get_next_turn() {
        global $turn;
        return $turn === "X" ? "O" : "X";
    }
    function get_status($gameboard) {
        $empty_cells = 0;
        foreach (WINNING_PATTERNS as $pattern) {
            $first = $gameboard[$pattern[0]];
            if (
                $first !== "-" &&
                $gameboard[$pattern[1]] === $first &&
                $gameboard[$pattern[2]] === $first
            ) {
                return $first;
            }
        }
        foreach (str_split($gameboard) as $cell) {
            if ($cell === "-") {
                $empty_cells++;
            }
        }
        return $empty_cells === 0 ? "TIE" : "-";
    }
    function get_href($index) {
        global $vs_friend;
        global $gameboard;
        global $turn;
        global $winner;
        if ($gameboard[$index] !== "-" || $winner !== "-") {
            return "?gameboard=" . $gameboard . "&turn=" . $turn . "&winner=" . $winner;
        } else {
            $gameboard_copy = $gameboard;
            $gameboard_copy[$index] = $turn;
            $next_turn = $vs_friend ? get_next_turn() : "X";
            if (!$vs_friend) {
                $computer_made_move = false;
                foreach (WINNING_PATTERNS as $pattern) {
                    if (
                        $gameboard_copy[$pattern[0]] === "-" &&
                        $gameboard_copy[$pattern[1]] === "O" &&
                        $gameboard_copy[$pattern[2]] === "O"
                    ) {
                        $computer_made_move = true;
                        $gameboard_copy[$pattern[0]] = "O";
                        break;
                    } else if (
                        $gameboard_copy[$pattern[0]] === "O" &&
                        $gameboard_copy[$pattern[1]] === "-" &&
                        $gameboard_copy[$pattern[2]] === "O"
                    ) {
                        $computer_made_move = true;
                        $gameboard_copy[$pattern[1]] = "O";
                        break;
                    } else if (
                        $gameboard_copy[$pattern[0]] === "O" &&
                        $gameboard_copy[$pattern[1]] === "O" &&
                        $gameboard_copy[$pattern[2]] === "-"
                    ) {
                        $computer_made_move = true;
                        $gameboard_copy[$pattern[2]] = "O";
                        break;
                    }
                }
                if (!$computer_made_move) {
                    foreach (WINNING_PATTERNS as $pattern) {
                        if (
                            $gameboard_copy[$pattern[0]] === "-" &&
                            $gameboard_copy[$pattern[1]] === "X" &&
                            $gameboard_copy[$pattern[2]] === "X"
                        ) {
                            $computer_made_move = true;
                            $gameboard_copy[$pattern[0]] = "O";
                            break;
                        } else if (
                            $gameboard_copy[$pattern[0]] === "X" &&
                            $gameboard_copy[$pattern[1]] === "-" &&
                            $gameboard_copy[$pattern[2]] === "X"
                        ) {
                            $computer_made_move = true;
                            $gameboard_copy[$pattern[1]] = "O";
                            break;
                        } else if (
                            $gameboard_copy[$pattern[0]] === "X" &&
                            $gameboard_copy[$pattern[1]] === "X" &&
                            $gameboard_copy[$pattern[2]] === "-"
                        ) {
                            $computer_made_move = true;
                            $gameboard_copy[$pattern[2]] = "O";
                            break;
                        }
                    }
                }
                if (!$computer_made_move) {
                    if ($gameboard_copy[4] === "-") {
                        $computer_made_move = true;
                        $gameboard_copy[4] = "O";
                    } else {
                        $computer_made_move = true;
                        $options = [0, 1, 2, 3, 4, 5, 6, 7, 8];
                        foreach (str_split($gameboard_copy) as $index => $cell) {
                            if ($cell !== "-") {
                                unset($options[$index]);
                            }
                        }
                        if (count($options) > 0) {
                            $gameboard_copy[array_rand($options)] = "O";
                        }
                    }
                }
            }
            $status = get_status($gameboard_copy);
            if ($status !== "-") {
                return "?gameboard=" . $gameboard_copy . "&turn=" . $next_turn . "&winner=" . $status;
            }
            return "?gameboard=" . $gameboard_copy . "&turn=" . $next_turn . "&winner=-";
        }
    }
?>
<table id="game">
    <?php if ($winner === "-") { ?>
        <caption>
            <?php if ($vs_friend) { ?>
                Player <?= $turn ?>'s Turn
            <?php } else { ?>
                Playing Against Computer
            <?php } ?>
        </caption>
    <?php } else if ($winner !== "-") { ?>
        <caption>
            <?php if ($vs_friend && $winner === "X") { ?>
                Player X Won!
            <?php } else if ($vs_friend && $winner === "O") { ?>
                Player O Won!
            <?php } else if (!$vs_friend && $winner === "X") { ?>
                You won!
            <?php } else if (!$vs_friend && $winner === "O") { ?>
                The computer won!
            <?php } else if ($winner === "TIE") { ?>
                Tie!
            <?php } ?>
            <a href="?gameboard=---------&turn=X&winner=-">New Game</a>
        </caption>
    <?php } ?>
    <tr>
        <td>
            <a
                href="<?= get_href(0) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(0) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(1) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(1) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(2) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(2) ?>
                </span>
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <a
                href="<?= get_href(3) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(3) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(4) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(4) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(5) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(5) ?>
                </span>
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <a
                href="<?= get_href(6) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(6) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(7) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(7) ?>
                </span>
            </a>
        </td>
        <td>
            <a
                href="<?= get_href(8) ?>"
                class="btn btn-primary <?= $winner !== "-" ? "disabled" : "" ?>"
            >
                <span>
                    <?= get_cell(8) ?>
                </span>
            </a>
        </td>
    </tr>
</table>
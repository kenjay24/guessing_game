<?php
session_start();

if (!isset($_SESSION['correct_number']) || isset($_POST['reset'])) {
    $_SESSION['correct_number'] = rand(1, 50);
    $_SESSION['tries_left'] = 5;
    $message = "You have 5 tries to guess the number between 1 and 50!<br>";
} elseif ($_SESSION['tries_left'] > 0) {
    $message = "You have {$_SESSION['tries_left']} tries remaining.";
}


if (isset($_POST['guess']) && $_POST['guess'] !== '' && $_SESSION['tries_left'] > 0) {
    $guess = intval($_POST['guess']);
    $_SESSION['tries_left']--;

    if ($guess == $_SESSION['correct_number']) {
        $message = "Congratulations! You guessed the correct number ({$_SESSION['correct_number']})!";
        $_SESSION['tries_left'] = 0;
    } elseif ($_SESSION['tries_left'] > 0) {
        if ($guess > $_SESSION['correct_number']) {
            $message = "Too high! Tries left: {$_SESSION['tries_left']}.";
        } else {
            $message = "Too low! Tries left: {$_SESSION['tries_left']}.";
        }
    } else {
        $message = "Game over! The correct number was {$_SESSION['correct_number']}.";
    }
} elseif (isset($_POST['guess']) && $_POST['guess'] === '') {
    $message = "Please enter a valid number. You still have {$_SESSION['tries_left']} tries left.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game</title>
</head>
<body>
    <h1>PHP Guessing Game</h1>
    <p><?php echo $message; ?></p>

    <?php if ($_SESSION['tries_left'] > 0): ?>
        <form method="post">
            <label for="guess">Enter your guess:</label>
            <input type="number" name="guess" id="guess" min="1" max="50" required>
            <button type="submit">Submit Guess</button>
        </form>
    <?php else: ?>

        <form method="post">
            <button type="submit" name="reset">Play Again</button>
        </form>
    <?php endif; ?>
    <br>


    <form method="post">
        <button type="submit" name="reset">Reset Game</button>
    </form>
</body>
</html>

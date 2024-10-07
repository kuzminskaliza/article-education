<?php

/* @var string $title */
/* @var string $header */
/* @var string $content */

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>
<body>
<header>
    <h1><?= $header ?></h1>
</header>
<section>
    <?= $content ?>
</section>
<footer>
    <p>Copyright &copy; <?= date('Y') ?></p>
</footer>
</body>
</html>


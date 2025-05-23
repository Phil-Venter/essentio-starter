<?php
/** @var \Essentio\Core\Extra\Template $this */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->yield("title", env("APP_NAME", "")) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <header class="container"><?= env("APP_NAME", "") ?></header>
    <main class="container"><?= $this->yield("content") ?></main>
    <footer class="container">&copy; <?= date("Y") ?></footer>
</body>

</html>

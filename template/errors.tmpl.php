<?php
/** @var \Essentio\Core\Extra\Template $this */
$this->layout(base_path("template/layout.tmpl.php")); ?>

<a href="/">Go back</a>
<h1>Whoops</h1>

<?php foreach ($errors ?? [] as $field => $error): ?>
    <?php foreach ($error as $message): ?>
        <p><?= $message ?></p>
    <?php endforeach; ?>
<?php endforeach; ?>

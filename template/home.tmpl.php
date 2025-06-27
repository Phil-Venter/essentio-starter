<?php
/** @var \Essentio\Core\Extra\Template $this */
$this->layout(base_path("template/layout.tmpl.php")); ?>

<h1>Hello, <?= htmlspecialchars($name ?? "You") ?></h1>

<?php if (!isset($name)): ?>
<form action="/" method="post">
    <input type="hidden" name="_csrf" value="<?= csrf() ?>">
    <input type="text" id="name" name="name" required>
    <button type="submit">I have a name</button>
</form>
<?php endif; ?>

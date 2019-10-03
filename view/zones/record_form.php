<?php include 'view/layout/header.php' ?>

<div class="container">
    <h3>Create a new <?= $type ?> record</h3>
    <?= $form->open() ?>
    <?php foreach ($form->getFields() as $field) : ?>
        <?= $field->render() ?>
    <?php endforeach; ?>

    <a class="btn btn-secondary" href="?action=zone_view&name=<?= $name ?>">Back</a>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <?= $form->close() ?>
</div>

<?php include 'view/layout/footer.php' ?>

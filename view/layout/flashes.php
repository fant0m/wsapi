<?php if (count($messages) > 0) : ?>
<div class="container">
    <?php foreach ($messages as $message) : ?>
    <div class="alert alert-dismissible alert-<?= $message['type'] ?> fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    
        <?= $message['text'] ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php
/** @var $error */
/** @var $color */
/** @var $text */
?>

<?php if (isset($error)): ?>
    <div class="text-center">
        <strong class="text-danger"><?= $error ?></strong>
    </div>
<?php else: ?>
    <div class="text-center">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
<?php endif; ?>

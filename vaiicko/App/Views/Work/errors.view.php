<?php
/** @var $error */
/** @var $color */
/** @var $text */
?>

<?php if (isset($error)): ?>
    <div class="text-center">
        <strong class="text-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></strong>
    </div>
<?php else: ?>
    <div class="text-center">
        <strong class="<?= isset($color) ? "text-" . htmlspecialchars($color, ENT_QUOTES, 'UTF-8') : '' ?>">
            <?= isset($text) ? htmlspecialchars($text, ENT_QUOTES, 'UTF-8') : '' ?>
        </strong>
    </div>
<?php endif; ?>


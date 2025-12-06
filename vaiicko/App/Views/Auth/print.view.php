<?php
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \App\Models\User[] $users */
/** @var  bool $isAdmin */
/** @var \Framework\Support\LinkGenerator $link */

?>

<h1>Zoznam používateľov</h1>
<div class="users-list">
<?php foreach ($users as $user): ?>
    <div class="card user-card">
        <div class="card-header">
            <div>
                <strong><?= $user->getUsername() ?></strong>
            </div>
        </div>
        <div class="card-body">
            <div class="user-field"><?= $user->getName() ?? ' ' . $user->getSurname() ?? '' ?></div>
            <div class="user-field"><?= $user->getEmail() ?></div>
            <div class="user-field">Na C&L od <?= $user->getCreatedAt() ?></div>
            <?php if ($isAdmin): ?>
                <div class="user-field">ID: <?= $user->getId() ?></div>
                <form method="post" action="<?= $link->url('auth.delete') ?>" onsubmit="return confirm('Delete user <?= addslashes($user->getUsername()) ?>?');">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    <button type="submit" class="btn-delete">Odstrániť používateľa</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

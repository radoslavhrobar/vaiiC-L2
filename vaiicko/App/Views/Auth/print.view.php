<?php
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \App\Models\User[] $users */
/** @var  bool $isAdmin */
/** @var \Framework\Support\LinkGenerator $link */

use App\Helpers\Role;

?>

<h3 class="titleName">Zoznam používateľov</h3>
<div class="user-list">
<?php foreach ($users as $user): ?>
    <div class="card user-card">
        <div class="card-header">
            <div>
                <strong><?= $user->getUsername() ?></strong>
            </div>
        </div>
        <div class="card-body">
            <?php if ($isAdmin): ?>
                <div class="user-field">ID: <?= $user->getId() ?></div>
            <?php endif; ?>
            <?php if ($user->getName() || $user->getSurname()): ?>
                <div class="user-field">
                    Meno: <?= ($user->getName() ?? '') . ' ' . ($user->getSurname() ?? '') ?>
                </div>
            <?php endif; ?>
            <div class="user-field">Email: <?= $user->getEmail() ?></div>
            <div class="user-field">Na C&L od <?= $user->getCreatedAt() ?></div>
            <?php if ($isAdmin && $user->getRole() !== Role::Admin->name): ?>
                <form method="post" action="<?= $link->url('auth.delete') ?>" onsubmit="return confirm('Odstrániť používateľa <?= addslashes($user->getUsername()) ?>?');">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    <button type="submit" class="btn-delete">Odstrániť používateľa</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

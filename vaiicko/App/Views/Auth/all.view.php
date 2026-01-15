<?php
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \App\Models\User[] $users */
/** @var  bool $isAdmin */
/** @var \Framework\Support\LinkGenerator $link */
/** @var int[] $reviewCounts */
/** @var int[] $ratingCounts */
use App\Helpers\Role;

?>

<h3 class="titleName">Zoznam používateľov</h3>
<div class="user-list">
<?php foreach ($users as $i => $user): ?>
    <?php if ($auth->getUser() && $user->getId() !== $auth->getUser()->getId()): ?>
        <div class="card user-card">
            <div class="card-header">
                <form action="<?= $link->url('auth.page') ?>" method="post">
                    <strong class="specialColor "><?= $i + 1 . '. ' ?></strong>
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    <button type="submit" class="listLinkButton"><?= $user->getUsername() ?></button>
                </form>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if ($user->getName() || $user->getSurname()): ?>
                            <div class="user-field">
                                <?= ($user->getName() ?? '') . ' ' . ($user->getSurname() ?? '') ?>
                            </div>
                        <?php endif; ?>
                        <div class="user-field">
                            <?= $ratingCounts[$i] ?> hodnotení
                        </div>
                        <div class="user-field">
                            <?= $reviewCounts[$i] ?> recenzií
                        </div>
                    </div>
                    <?php if ($isAdmin && $user->getRole() !== Role::Admin->name): ?>
                        <form method="post" action="<?= $link->url('auth.delete') ?>" onsubmit="return confirm('Odstrániť používateľa <?= addslashes($user->getUsername()) ?>?');">
                            <input type="hidden" name="id" value="<?= $user->getId() ?>">
                            <button type="submit" class="btn-delete">Odstrániť</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
</div>

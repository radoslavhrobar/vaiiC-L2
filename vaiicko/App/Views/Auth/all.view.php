<?php
/** @var \Framework\Core\IAuthenticator $auth */
/** @var $data */
/** @var  bool $isAdmin */
/** @var \Framework\Support\LinkGenerator $link */
/** @var $text */
/** @var $color */
use App\Helpers\Role;

?>

<div class="text-center my-2">
    <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
</div>
<h3 class="titleName">Zoznam používateľov</h3>
<div class="user-list">
<?php foreach ($data as $i => $d): ?>
        <div class="card user-card">
            <div class="card-header">
                <form action="<?= $link->url('auth.page') ?>" method="post">
                    <strong class="specialColor "><?= $i + 1 . '. ' ?></strong>
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <button type="submit" class="listLinkButton"><?= $d['username'] ?></button>
                </form>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if ($d['name'] || $d['surname']): ?>
                            <div class="mb-2">
                                <strong class="text-secondary"><?= ($d['name'] ?? '') . ' ' . ($d['surname'] ?? '') ?></strong>
                            </div>
                        <?php endif; ?>
                        <div>
                            📝 <?= $d['review_count'] ?> recenzií
                        </div>
                        <div class="ms-1">
                            <i class="bi bi-star-fill text-danger"></i> <?= $d['rating_count'] ?> hodnotení
                        </div>
                        <div>
                            ❤️ <?= $d['fav_count'] ?> obľúbených
                        </div>
                    </div>
                    <?php if ($isAdmin && $d['role'] !== Role::Admin->name): ?>
                        <form method="post" action="<?= $link->url('auth.delete') ?>"
                              onsubmit="return confirm('Odstrániť používateľa <?= addslashes($d['username']) ?>?');">
                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                            <button type="submit" class="bg-danger btn-delete">Odstrániť</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<?php endforeach; ?>
</div>

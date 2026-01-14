<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\User $user */
/** @var \App\Models\Review[] $reviews */
/** @var \App\Models\Review[] $ratings */
/** @var $favGenres */
/** @var $countFav */
/** @var $percentages */
?>
<div class="baseInfoRow row rounded mx-2 my-3 p-3 border">
    <div class="col-md-6 userInfoCol rounded p-3">
        <h3 class="fw-bold mb-3"><?= $user->getUsername() ?></h3>
        <div>
            <?= $user->getName() !== null ? 'Meno: <strong>' . $user->getName() . ' ' . ($user->getSurname() ?? '') . '</strong>' : '' ?>
        </div>
        <div>
            Email: <strong><?= $user->getEmail() ?></strong>
        </div>
        <div>
            <?= $user->getGender() !== null ? 'Pohlavie: <strong>' . \App\Helpers\Gender::valueFrom($user->getGender()) . '</strong>' : '' ?>
        </div>
        <div>
            Na C&L od: <strong><?= (new DateTime($user->getCreatedAt()))->format('Y-m-d') ?></strong>
        </div>
        <div>
            Počet obľúbených diel: <strong><?= $countFav ?></strong>
        </div>
    </div>
    <div class="col-md-6">
        <h5 class="fw-bold">Najobľúbenejšie žánre:</h5>
        <?php if (!empty($favGenres)): ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($favGenres as $i => $genre): ?>
                    <div>
                        <div class="mb-1">
                            <strong><?= $genre['name'] ?></strong>
                        </div>
                        <div class="progress">
                            <div class="bg-warning" style="width: <?= $percentages[$i] ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Používateľ zatiaľ nemá obľúbené žánre.</p>
        <?php endif; ?>
    </div>
</div>


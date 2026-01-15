<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\User $user */
/** @var $worksRatings */
/** @var $worksReviews */
/** @var $favoriteWorks */
/** @var $favGenres */
/** @var $percentages */
/** @var $whichActive */
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
<div class="btn-group w-100 mb-4">
    <button class="btn btnUserPage <?= $whichActive === 'reviews' ? 'active' : '' ?>" onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'reviews']) ?>'">
        📝 Recenzie
    </button>
    <button class="btn btnUserPage <?= $whichActive === 'ratings' ? 'active' : '' ?>" onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'ratings']) ?>'">
        <i class="bi bi-star-fill text-danger"></i> Hodnotenia
    </button>
    <button class="btn btnUserPage <?= $whichActive === 'favs' ? 'active' : '' ?>" onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'favs']) ?>'">
        ❤️ Obľúbené diela
    </button>
</div>
<div class="pageParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Recenzie
        <span class="text-secondary">(<?= count($worksReviews) ?>)</span>
    </h4>

    <?php foreach ($worksReviews as $i => $workReview): ?>
            <div class="card pageParts mb-3">
                <div class="card-body d-flex flex-column">
                    <div>
                    </div>
                    <div>
                        <div>
                            <a class="listLink" href="<?= $workReview ['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $workReview['id']]) : ($workReview ['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $workReview['id']]) : ($workReview ['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $workReview['id']]) : '#')); ?>"><?= $workReview['name'] ?> </a>
                            <span class="userRating fw-normal">
                                <?php for ($j = 0; $j < $workReview['rating']; $j++): ?>
                                    ★
                                <?php endfor; ?>
                            </span>
                            <span class="text-secondary"> (<?= (new DateTime($workReview['date_of_issue']))->format('Y') . ', ' . $workReview['type']?>)</span>
                        </div>
                        <div>
                            <?= $workReview['body'] ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
</div>




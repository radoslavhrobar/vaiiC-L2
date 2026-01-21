<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\Review[] $ratings */
/** @var $data */
/** @var bool $hasReview */
/** @var \App\Models\Review $myReview */
/** @var bool $isFavorite */
/** @var $text */
/** @var $color */
/** @var \Framework\Core\IAuthenticator $auth */
?>

<div class="pageParts p-4 rounded mb-3">
    <h5 class="fw-bold mb-3">Obsah</h5>
    <p class="text-secondary">
        <?= htmlspecialchars($work->getDescription(), ENT_QUOTES, 'UTF-8') ?>
    </p>
</div>

<?php if ($auth->isLogged()): ?>
    <div class="d-flex align-items-center mb-3">
        <strong><?= !$isFavorite ? 'Pridať do obľúbených:' : 'Odobrať z obľúbených:' ?></strong>
        <i id="favoriteHeart" class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' ?> fs-2 ms-3" data-work-id="<?= (int)$work->getId() ?>" role="button"></i>
    </div>
<?php endif; ?>

<div class="pageParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Recenzie
        <span class="text-secondary">(<?= count($data) ?>)</span>
    </h4>

    <?php foreach ($data as $i => $d):
        if (!$myReview || $d['id'] !== $myReview->getId()):?>
            <div class="card pageParts mb-3">
                <div class="card-body">
                    <div>
                        <strong class="fw-bold fs-5"><?= htmlspecialchars($d['username'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="userRating fw-normal">
                            <?php for ($j = 0; $j < $d['rating']; $j++): ?>
                                ★
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="mb-0 mt-2">
                        <?= htmlspecialchars($d['body'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="text-center">
        <strong class="<?= isset($color) ? "text-" . htmlspecialchars($color, ENT_QUOTES, 'UTF-8') : '' ?>">
            <?= isset($text) ? htmlspecialchars($text, ENT_QUOTES, 'UTF-8') : '' ?>
        </strong>
    </div>

    <?php if ($myReview): ?>
        <h4 class="fw-bold mb-4">
            <?= $myReview->getBody() === null ? 'Moje Hodnotenie' : 'Moja Recenzia' ?>
        </h4>

        <div class="card pageParts mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="fw-bold fs-5"><?= htmlspecialchars($auth->getUser()->getUsername(), ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="userRating fw-normal">
                            <?php for ($j = 0; $j < $myReview->getRating(); $j++): ?>
                                ★
                            <?php endfor; ?>
                        </span>
                        <p class="mb-0 mt-2">
                            <?= htmlspecialchars($myReview->getBody() ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!$hasReview): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Pridať recenziu</h5>
                <form id="reviewForm" class="forms" action="<?= $link->url("review.add", ['workId' => (int)$work->getId()]) ?>" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" name="body" id="reviewBody" placeholder="Napíš svoju recenziu..."></textarea>
                        <div class="text-center">
                            <strong id="reviewBodyMessage"></strong>
                        </div>
                    </div>
                    <span>Hodnotenie:</span>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="starRating d-flex flex-column align-items-center">
                            <div>
                                <input type="hidden" id="noStar" name="rating" value="">
                                <?php for ($r = 5; $r >= 1; $r--): ?>
                                    <input type="radio" id="star<?= $r ?>" name="rating" value="<?= $r ?>">
                                    <label for="star<?= $r ?>"><?= str_repeat('★', $r) ?></label>
                                <?php endfor; ?>
                            </div>
                            <div class="text-center">
                                <strong id="ratingMessage"></strong>
                            </div>
                        </div>
                        <button type="submit" class="btn-brown">Odoslať</button>
                    </div>
                </form>
            </div>
        </div>
    <?php elseif ($myReview): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Upraviť recenziu</h5>
                <form id="reviewForm" class="forms" action="<?= $link->url("review.edit", ['workId' => (int)$work->getId(), 'id' => (int)$myReview->getId()]) ?>" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" id="reviewBody" name="body" placeholder="Napíš svoju recenziu..."><?= htmlspecialchars($myReview->getBody() ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        <div class="text-center">
                            <strong id="reviewBodyMessage"></strong>
                        </div>
                    </div>
                    <span>Hodnotenie:</span>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="starRating flex-grow-1">
                            <input type="hidden" id="noStar" name="rating" value="">
                            <?php for ($r = 5; $r >= 1; $r--): ?>
                                <input type="radio" id="star<?= $r ?>" name="rating" value="<?= $r ?>" <?= $myReview->getRating() === $r ? 'checked' : '' ?>>
                                <label for="star<?= $r ?>"><?= str_repeat('★', $r) ?></label>
                            <?php endfor; ?>
                        </div>
                        <button type="submit" class="btn-brown">Upraviť</button>
                        <button type="button" class="bg-danger btn-delete"
                                onclick="return confirm('Odstrániť recenziu ku dielu <?= addslashes(htmlspecialchars($work->getName(), ENT_QUOTES, 'UTF-8')) ?>?')
                                        && (window.location.href='<?= $link->url("review.delete", ['id' => (int)$myReview->getId()]) ?>');">
                            Odstrániť
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="<?= $link->asset('js/reviews.js') ?>"></script>
<script src="<?= $link->asset('js/favorites.js') ?>"></script>

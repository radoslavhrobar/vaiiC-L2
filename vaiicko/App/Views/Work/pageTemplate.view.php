<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\Review[] $ratings */
/** @var $data */
/** @var bool $hasReview */
/** @var \App\Models\Review $myReview */
/** @var bool $isFavorite */
/** @var string $text */
/** @var string $color */
/** @var \Framework\Core\IAuthenticator $auth */
?>

<div class="pageParts p-4 rounded mb-3">
    <h5 class="fw-bold mb-3">Obsah</h5>
    <p class="text-secondary">
        <?= $work->getDescription() ?>
    </p>
</div>

<?php if ($auth->isLogged()): ?>
    <div class="d-flex align-items-center mb-3">
        <strong><?= !$isFavorite ? 'Pridať do obľúbených:' : 'Odobrať z obľúbených:' ?></strong>
        <i id="favoriteHeart" class="bi <?= $isFavorite ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' ?> fs-2 ms-3" data-work-id="<?= $work->getId() ?>" role="button"></i>
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
                        <strong class="fw-bold fs-5"><?= $d['username'] ?></strong>
                        <span class="userRating fw-normal">
                            <?php for ($j = 0; $j < $d['rating']; $j++): ?>
                                ★
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="mb-0 mt-2">
                        <?= $d['body'] ?: ''  ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($myReview): ?>
        <div class="text-center">
            <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
        </div>
        <h4 class="fw-bold mb-4">
            <?php if ($myReview->getBody() === null): ?>
                Moje Hodnotenie
            <?php else: ?>
                Moja Recenzia
            <?php endif; ?>
        </h4>

        <div class="card pageParts mb-3">
            <div class="card-body">
                <div>
                    <strong class="fw-bold fs-5"><?= $auth->getUser()->getUsername() ?></strong>
                    <span class="userRating fw-normal">
                                <?php for ($j = 0; $j < $myReview->getRating(); $j++): ?>
                                    ★
                                <?php endfor; ?>
                            </span>
                </div>
                <p class="mb-0 mt-2">
                    <?= $myReview->getBody() ?: '' ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!$hasReview): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Pridať recenziu</h5>
                <form  id="reviewForm" class="forms" action="<?= $link->url("review.add", ['workId' => $work->getId()]) ?>" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" name="body" id="reviewBody" placeholder="Napíš svoju recenziu..."></textarea>
                        <div class="text-center">
                            <strong  id="reviewBodyMessage"></strong>
                        </div>
                    </div>
                    <span>Hodnotenie:</span>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="starRating d-flex flex-column align-items-center">
                            <div>
                                <input type="hidden" id="noStar" name="rating" value="">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5">★★★★★</label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4">★★★★</label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3">★★★</label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2">★★</label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1">★</label>
                            </div>
                            <div class="text-center">
                                <strong  id="ratingMessage"></strong>
                            </div>
                        </div>
                        <button type="submit" class="btn-brown">
                            Odoslať
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php elseif($myReview): ?>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Upraviť recenziu</h5>
            <form id="reviewForm" class="forms" action="<?= $link->url("review.edit", ['workId' => $work->getId(), 'id' => $myReview->getId()]) ?>" method="post">
                <div class="mb-3">
                    <textarea class="form-control" rows="3" id="reviewBody" name="body" placeholder="Napíš svoju recenziu..."><?= $myReview->getBody() ?></textarea>
                    <div class="text-center">
                        <strong id="reviewBodyMessage"></strong>
                    </div>
                </div>
                <span>Hodnotenie:</span>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <div class="starRating">
                        <input type="hidden" id="noStar" name="rating" value="">
                        <input type="radio" id="star5" name="rating" value="5" <?=  $myReview->getRating() === 5 ? 'checked' : '' ?>>
                        <label for="star5">★★★★★</label>
                        <input type="radio" id="star4" name="rating" value="4" <?=  $myReview->getRating() === 4 ? 'checked' : '' ?>>
                        <label for="star4">★★★★</label>
                        <input type="radio" id="star3" name="rating" value="3" <?=  $myReview->getRating() === 3 ? 'checked' : '' ?>>
                        <label for="star3">★★★</label>
                        <input type="radio" id="star2" name="rating" value="2" <?=  $myReview->getRating() === 2 ? 'checked' : '' ?>>
                        <label for="star2">★★</label>
                        <input type="radio" id="star1" name="rating" value="1" <?=  $myReview->getRating() === 1 ? 'checked' : '' ?>>
                        <label for="star1">★</label>
                    </div>
                    <button type="submit" class="btn-brown">
                        Upraviť
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
<script src="<?= $link->asset('js/reviews.js') ?>"></script>
<script src="<?= $link->asset('js/favorites.js') ?>"></script>
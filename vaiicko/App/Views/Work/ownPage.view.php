<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\MovieDetail $movieDetail */
/** @var \App\Models\BookDetail $bookDetail */
/** @var \App\Models\SeriesDetail $seriesDetail */
/** @var \App\Models\Genre $genreByWorkId */
/** @var \App\Models\Country $countryByWorkId */
/** @var \App\Models\Review[] $reviews */
/** @var \App\Models\Review[] $reviewsFiltered */
/** @var \App\Models\User[] $users */
/** @var bool $hasReview */
/** @var \App\Models\Review $myReview */
/** @var string $text */
/** @var string $color */
/** @var \Framework\Core\IAuthenticator $auth */
?>
<div class="row workRow p-4 rounded my-3">
    <div class="col-6 col-md-3 text-center order-1 order-md-1 mb-3 mb-md-0">
        <img src="poster.jpg"
             class="img-fluid rounded"
             alt="Plagát diela">
    </div>
    <div class="col-12 col-md-6 order-3 order-md-2">
        <h3 class="fw-bold">
            <?= $work->getName() ?>
            <span class="text-secondary">(<?= $work->getType() ?>)</span>
        </h3>
        <div class="text-secondary mb-2">
            <?= $countryByWorkId->getName()  ?> • <?= (new DateTime($work->getDateOfIssue()))->format('Y') ?> • <?= $genreByWorkId->getName()  ?>
        </div>
        <div class="workInfoList">
            <?php if ($work->getType() === 'Film' || $work->getType() === 'Seriál'):
                 if ($work->getType() === 'Film'): ?>
                    <div class="mb-1">
                        Dĺžka:
                        <span class="fw-bold"> <?= $movieDetail->getLength() ?> min </span>
                    </div>
                <?php else: ?>
                    <div class="mb-1">
                        Počet sérií:
                        <span class="fw-bold"> <?= $seriesDetail->getNumOfSeasons() ?>
                    </div>
                    <div class="mb-1">
                        Počet epizód:
                        <span class="fw-bold"> <?= $seriesDetail->getNumOfEpisodes() ?>
                    </div>
                <?php endif; ?>
                <div class="mb-1">
                    Produkčná spoločnosť:
                    <span class="fw-bold"> <?= $work->getType() === 'Film' ? $movieDetail->getProdCompany() : $seriesDetail->getProdCompany() ?>
                </div>
                <div class="mb-1">
                    Režisér:
                    <span class="fw-bold"> <?= $work->getType() === 'Film' ? $movieDetail->getDirector() : $seriesDetail->getDirector()?>
                </div>
            <?php elseif ($work->getType() === 'Kniha'): ?>
                <div class="mb-1">
                    Počet strán:
                    <span class="fw-bold"> <?= $bookDetail->getNumOfPages() ?>
                </div>
                <div class="mb-1">
                    Vydavateľstvo:
                    <span class="fw-bold"> <?= $bookDetail->getPublishers() ?>
                </div>
                <div class="mb-1">
                    Autor:
                    <span class="fw-bold"> <?= $bookDetail->getAuthor() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-6 col-md-3 text-center d-flex flex-column justify-content-center order-2 order-md-3 mb-3 mb-md-0">
        <div class="specialBackgroundColor text-white fw-bold py-3 display-6 rounded">
            Picus
        </div>
        <div class="text-secondary mt-2">
            <?= count($reviews) ?> hodnotení
        </div>
    </div>
</div>
<div class="workParts p-4 rounded mb-5">
    <h5 class="fw-bold mb-3">Obsah</h5>
    <p class="text-secondary">
        <?= $work->getDescription() ?>
    </p>
</div>

<div class="workParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Recenzie
        <span class="text-secondary">(<?= count($reviewsFiltered) ?>)</span>
    </h4>

    <?php foreach ($reviewsFiltered as $i => $review):
        if (!$myReview || $review->getId() !== $myReview->getId()):?>
            <div class="card workParts mb-3">
                <div class="card-body">
                    <div>
                        <strong class="fw-bold fs-5"><?= $users[$i]->getUsername() ?></strong>
                        <span class="userRating fw-normal">
                            <?php for ($j = 0; $j < $review->getRating(); $j++): ?>
                                ★
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="mb-0 mt-2">
                        <?= $review->getBody() ?: ''  ?>
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

        <div class="card workParts mb-3">
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
                <form  id="reviewForm" action="<?= $link->url("review.add", ['workId' => $work->getId()]) ?>" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" name="body" id="reviewBody" placeholder="Napíš svoju recenziu..."></textarea>
                        <div class="errorMessage" id="reviewBodyMessage"></div>
                    </div>
                    <span>Hodnotenie:</span>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div class="starRating">
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
                        <div class="errorMessage" id="ratingMessage"></div>
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
            <form  id="review" action="<?= $link->url("review.edit", ['workId' => $work->getId(), 'id' => $myReview->getId()]) ?>" method="post">
                <div class="mb-3">
                    <textarea class="form-control" rows="3" id="reviewBody" name="body" placeholder="Napíš svoju recenziu..."><?= $myReview->getBody() ?></textarea>
                    <div class="errorMessage" id="reviewBodyMessage"></div>
                </div>
                <span>Hodnotenie:</span>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <div class="starRating">
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
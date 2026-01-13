<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\BookDetail $bookDetail */
/** @var \App\Models\Genre $genreByWorkId */
/** @var \App\Models\Country $countryByWorkId */
/** @var \App\Models\Review[] $reviews */
/** @var float $avgRating */
?>
<div class="row workRow p-4 rounded my-3">
    <div class="col-6 col-md-3 text-center order-1 order-md-1 mb-3 mb-md-0">
        <img src="<?= $link->asset('images' . $work->getName()) ?>"
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
        </div>
    </div>
    <div class="col-6 col-md-3 text-center d-flex flex-column justify-content-center order-2 order-md-3 mb-3 mb-md-0">
        <div class="specialBackgroundColor text-white fw-bold py-3 display-6 rounded">
            <?= $avgRating ?>%
        </div>
        <div class="text-secondary mt-2">
            <?= count($reviews) ?> hodnotení
        </div>
    </div>
</div>
<?php require __DIR__ . '/../Work/pageTemplate.view.php' ?>
<div class="text-center">
    <button onclick="window.location.href='<?= $link->url("bookDetail.edit", ['id' => $work->getId()]) ?>'" type="submit" class="btn-brown">
        Upraviť detaily knihy
</div>

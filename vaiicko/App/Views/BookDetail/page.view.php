<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\BookDetail $bookDetail */
/** @var \App\Models\Genre $genreByWorkId */
/** @var \App\Models\Country $countryByWorkId */
/** @var \App\Models\Review[] $ratings */
/** @var $avgRating */
/** @var $favCount */
/** @var \Framework\Core\IAuthenticator $auth */
?>
<div class="row baseInfoRow p-4 rounded my-3">
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
        <div class="text-white fw-bold py-3 display-6 rounded <?= $avgRating >= 4.5
            ? 'first'
            : ($avgRating >= 3.5
                ? 'second'
                : ($avgRating >= 2.5
                    ? 'third'
                    : 'last'
                )
            )
        ?>">
            <?= $avgRating/5*100 ?>%
        </div>
        <div class="text-secondary fw-bold mt-2">
            <?= count($ratings) ?> hodnotení
        </div>
        <div class="text-secondary fw-bold mt-2">
            <?= $favCount ?> ❤️
        </div>
    </div>
</div>
<?php require __DIR__ . '/../Work/pageTemplate.view.php' ?>
<?php if ($auth->isLogged() && $auth->getUser()->getRole() === 'Admin'): ?>
    <div class="d-flex gap-4 mb-4 justify-content-center align-items-center">
        <div class="text-center">
            <button onclick="window.location.href='<?= $link->url("bookDetail.edit", ['id' => $work->getId()]) ?>'" type="submit" class="btn-brown">
                Upraviť detaily knihy
        </div>
        <div class="text-center">
            <button
                    type="button"
                    class="bg-danger btn-delete"
                    onclick="return confirm('Odstrániť knihu <?= addslashes($work->getName()) ?>?')
                            && (window.location.href='<?= $link->url("bookDetail.delete", ['id' => $work->getId()]) ?>');">
                Odstrániť knihu
            </button>
        </div>
    </div>
<?php endif; ?>

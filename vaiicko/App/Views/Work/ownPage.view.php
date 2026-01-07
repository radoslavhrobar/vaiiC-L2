<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Work $work */
/** @var \App\Models\MovieDetail $movieDetail */
/** @var \App\Models\BookDetail $bookDetail */
/** @var \App\Models\SeriesDetail $seriesDetail */
/** @var \App\Models\Genre $genreByWorkId */
/** @var \App\Models\Country $countryByWorkId */

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
            87 %
        </div>
        <div class="text-secondary mt-2">
            10 721 hodnotení
        </div>
    </div>
</div>
<div class="workParts p-4 rounded mb-5">
    <h5 class="fw-bold mb-3">Obsah</h5>
    <p class="text-secondary">
        <?= $work->getDescription() ?>
    </p>
</div>
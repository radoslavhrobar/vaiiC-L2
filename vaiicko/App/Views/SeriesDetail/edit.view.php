<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var \App\Models\SeriesDetail $seriesDetail */
/** @var string $text */
/** @var string $color */
?>

<form id="seriesForm" class="forms formsOrganized" action="<?= $link->url("seriesDetail.editSeries") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <h4 class="titleName mt-4">Upravenie seriálu</h4>
    <?php require __DIR__ . '/../Work/editTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="numOfSeasons">Počet sezón:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="50" name="numOfSeasons" id="numOfSeasons" value="<?= $seriesDetail->getNumOfSeasons() ?>" required>
        <strong id="numOfSeasonsMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="numOfEpisodes">Počet epizód:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="3000" name="numOfEpisodes" id="numOfEpisodes" value="<?= $seriesDetail->getNumOfEpisodes() ?>" required>
        <strong id="numOfEpisodesMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="prodCompany">Produkčná spoločnosť:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="prodCompany" id="prodCompany" value="<?= $seriesDetail->getProdCompany() ?>">
        <strong id="prodCompanyMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="director">Režisér:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="director" id="director" value="<?= $seriesDetail->getDirector() ?>">
        <strong id="directorMessage"></strong>
    </div>
    <div class="text-center">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Upraviť seriál">
    </div>
</form>
<script src="<?= $link->asset('js/works.js') ?>"></script>


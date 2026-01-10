<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var string $text */
/** @var string $color */
?>

<form id="seriesForm" class="forms" action="<?= $link->url("seriesDetail.add") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require __DIR__ . '/../Work/adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie seriálu</h4>
    <?php require __DIR__ . '/../Work/workTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="numOfSeasons">Počet sezón:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="50" name="numOfSeasons" id="numOfSeasons" required>
        <strong id="numOfSeasonsMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="numOfEpisodes">Počet epizód:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="3000" name="numOfEpisodes" id="numOfEpisodes" required>
        <strong id="numOfEpisodesMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="prodCompany">Produkčná spoločnosť:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="prodCompany" id="prodCompany">
        <strong id="prodCompanyMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="director">Režisér:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="director" id="director">
        <strong id="directorMessage"></strong>
    </div>
    <div class="text-center">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať seriál">
    </div>
</form>
<script src="<?= $link->asset('js/works.js') ?>"></script>

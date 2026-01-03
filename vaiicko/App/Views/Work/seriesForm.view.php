<?php
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="workForm" class="forms" action="<?= $link->url("work.addSeries") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require 'adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie seriálu</h4>
    <?php require 'workTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="numOfSeasons">Počet sezón:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" name="numOfSeasons" id="numOfSeasons">
        <span id="numOfSeasonsMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="numOfEpisodes">Počet epizód:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" name="numOfEpisodes" id="numOfEpisodes">
        <span id="numOfEpisodesMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="prodCompany">Produkčná spoločnosť:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="prodCompany" id="prodCompany">
        <span id="prodCompanyMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="director">Režisér:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="director" id="director">
        <span id="directorMessage"></span>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať seriál">
    </div>
</form>

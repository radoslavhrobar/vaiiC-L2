<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var \App\Models\Country[] $countries */
/** @var \App\Models\Genre[] $genres */
?>

<form id="workForm" class="forms" action="<?= $link->url("movieDetail.add") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require __DIR__ . '/../Work/adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie filmu</h4>
    <?php require __DIR__ . '/../Work/workTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="movieLength">Dĺžka filmu (minúty):
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" name="movieLength" id="movieLength">
        <span id="lengthMessage"></span>
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
        <span><?= $message ?? '' ?></span>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať film">
    </div>
</form>

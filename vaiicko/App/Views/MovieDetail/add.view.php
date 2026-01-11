<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var string $text */
/** @var string $color */
?>

<form id="movieForm" class="forms formsOrganized" action="<?= $link->url("movieDetail.addMovie") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require __DIR__ . '/../Work/adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie filmu</h4>
    <?php require __DIR__ . '/../Work/addTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="movieLength">Dĺžka filmu (minúty):
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="600" name="movieLength" id="movieLength" required>
        <strong id="lengthMessage"></strong>
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
        <input class="btn-brown" type="submit" value="Pridať film">
    </div>
</form>
<script src="<?= $link->asset('js/works.js') ?>"></script>

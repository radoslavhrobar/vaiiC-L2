<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var \App\Models\MovieDetail $movieDetail */
/** @var string $text */
/** @var string $color */
?>

<form id="movieEdit" class="forms formsOrganized" action="<?= $link->url("movieDetail.editMovie") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <h4 class="titleName mt-4">Úprava filmu</h4>
    <?php require __DIR__ . '/../Work/editTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="movieLength">Dĺžka filmu (minúty):
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" min="1" max="600" name="movieLength" id="movieLength" value="<?= $movieDetail->getLength() ?>" required>
        <strong id="lengthMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="prodCompany">Produkčná spoločnosť:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="prodCompany" id="prodCompany" value="<?= $movieDetail->getProdCompany() ?>">
        <strong id="prodCompanyMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="director">Režisér:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="director" id="director" value="<?= $movieDetail->getDirector() ?>">
        <strong id="directorMessage"></strong>
    </div>
    <?php require __DIR__ . '/../Work/errors.view.php' ?>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Upraviť film">
    </div>
</form>
<script src="<?= $link->asset('js/works.js') ?>"></script>

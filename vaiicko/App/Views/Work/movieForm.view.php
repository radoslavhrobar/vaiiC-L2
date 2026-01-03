<?php
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="workForm" class="forms" action="<?= $link->url("work.addMovie") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require 'adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie filmu</h4>
    <?php require 'workTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="length">Dĺžka filmu (minúty):
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" name="length" id="length">
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
        <span id="director"></span>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať film">
    </div>
</form>

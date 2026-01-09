<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var string $text */
/** @var string $color */
?>

<form id="workForm" class="forms" action="<?= $link->url("bookDetail.add") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require __DIR__ . '/../Work/adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie knihy</h4>
    <?php require __DIR__ . '/../Work/workTemplate.view.php' ?>
    <div class="row">
        <label class="col-sm-3" for="numOfPages">Počet strán:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="number" name="numOfPages" id="numOfPages">
        <span id="lengthMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="publishers">Vydavateľstvo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="publishers" id="publishers">
        <span id="publishersMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="author">Autor:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="author" id="author">
        <span id="authorMessage"></span>
    </div>
    <div class="text-center">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať knihu">
    </div>
</form>

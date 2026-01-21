<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var \App\Models\BookDetail $bookDetail */
/** @var string $text */
/** @var string $color */
?>

<form id="bookEdit" class="forms formsOrganized"
      action="<?= $link->url("bookDetail.editBook") ?>"
      enctype="multipart/form-data"
      method="post"
      autocomplete="on">

    <h4 class="titleName mt-4">Úprava knihy</h4>

    <?php require __DIR__ . '/../Work/editTemplate.view.php' ?>

    <div class="row">
        <label class="col-sm-3" for="numOfPages">Počet strán:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6"
               type="number"
               min="1"
               max="5000"
               name="numOfPages"
               id="numOfPages"
               value="<?= (int)$bookDetail->getNumOfPages() ?>"
               required>
        <strong id="numOfPagesMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="publishers">Vydavateľstvo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6"
               type="text"
               name="publishers"
               id="publishers"
               value="<?= htmlspecialchars($bookDetail->getPublishers(), ENT_QUOTES, 'UTF-8') ?>">
        <strong id="publishersMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="author">Autor:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6"
               type="text"
               name="author"
               id="author"
               value="<?= htmlspecialchars($bookDetail->getAuthor(), ENT_QUOTES, 'UTF-8') ?>">
        <strong id="authorMessage"></strong>
    </div>

    <?php require __DIR__ . '/../Work/errors.view.php' ?>

    <div class="text-center">
        <input class="btn-brown" type="submit" value="'Upraviť knihu">
    </div>
</form>

<script src="<?= $link->asset('js/works.js') ?>"></script>

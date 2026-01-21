<?php
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="bookAdd" class="forms formsOrganized"
      action="<?= $link->url("bookDetail.addBook") ?>"
      enctype="multipart/form-data"
      method="post"
      autocomplete="on">

    <?php require __DIR__ . '/../Work/adding.view.php' ?>

    <h4 class="titleName mt-4">Pridanie knihy</h4>

    <?php require __DIR__ . '/../Work/addTemplate.view.php' ?>

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
               id="publishers">
        <strong id="publishersMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="author">Autor:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6"
               type="text"
               name="author"
               id="author">
        <strong id="authorMessage"></strong>
    </div>

    <?php require __DIR__ . '/../Work/errors.view.php' ?>

    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať knihu">
    </div>
</form>

<script src="<?= $link->asset('js/works.js') ?>"></script>

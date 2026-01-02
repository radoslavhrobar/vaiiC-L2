<?php
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="workForm" class="forms" action="<?= $link->url("work.addMovie") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <?php require 'adding.view.php' ?>
    <h4 class="titleName mt-4">Pridanie filmu</h4>
    <?php require 'workTemplate.view.php' ?>

    <div class="text-center">
        <input class="btn-brown" type="submit" value="Pridať film">
    </div>
</form>

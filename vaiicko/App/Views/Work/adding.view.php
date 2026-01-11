<?php
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="typesOfWork row mt-4">
    <span class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2">
        <input class="btn-brown" type="button" value="Film" onclick="window.location.href='<?= $link->url("movieDetail.add") ?>'">
    </span>
    <span class="col-lg-4 text-center mb-lg-0 mb-2">
        <input class="btn-brown" type="button" value="Seriál" onclick="window.location.href='<?= $link->url("seriesDetail.add") ?>'">
    </span>
    <span class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2">
        <input class="btn-brown" type="button" value="Kniha" onclick="window.location.href='<?= $link->url("bookDetail.add") ?>'">
    </span>
</div>


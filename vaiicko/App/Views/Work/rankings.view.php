<?php
/** @var \App\Helpers\TypesOfWork[] $types */
/** @var \App\Models\Genre[] $genres */
/** @var \Framework\Support\LinkGenerator $link */
?>

<form id="workForm" class="forms" action="<?= $link->url("work.rankings") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <h3 class="titleName">Rebríček</h3>
    <div class="filters row mt-4">
        <div class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="typeOfWork">Typ:</label>
            <select name="typeOfWork"  id="typeOfWork">
                <option value="všetky">-všetky-</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type->name ?>"><?= $type->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="genreRankings">Žáner: </label>
            <select id="genreRankings" name="genreRankings">
                <option value="všetky">-všetky-</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre->getId() ?>"><?= $genre->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="yearFrom">Obdobie: </label>
            <input id="yearFrom" type="number" name="yearFrom" value="<?= \App\Helpers\TypesOfWork::minYear() ?>" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="2026" style="width:80px" />
            <label class="filterLabel ms-2" for="yearTo">—</label>
            <input id="yearTo" type="number" name="yearTo" value="2026" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="2026" style="width:80px" />
        </div>
    </div>
    <div class="text-center mt-3">
        <input class="btn-brown" type="submit" value="Zobraziť">
    </div>
</form>
<script src="<?= $link->asset('js/rankings.js') ?>"></script>

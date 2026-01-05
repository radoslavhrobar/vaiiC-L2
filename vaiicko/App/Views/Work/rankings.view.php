<?php
/** @var \App\Helpers\TypesOfWork[] $types */
/** @var \App\Models\Genre[] $genres */
?>

<h3 class="titleName">Rebríček</h3>
<div class="controls row mt-4">
    <div class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="type">Typ:</label>
        <select name="type"  id="type">
            <option value="all">-všetky-</option>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type->name ?>"><?= $type->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-4 text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="genre">Žáner: </label>
        <select id="genre" name="genre">
            <option value="">-všetky-</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= $genre->getId() ?>"><?= $genre->getName() ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="yearFrom">Obdobie: </label>
        <input id="yearFrom" type="number" min="" max="2026" placeholder="od" style="width:80px" />
        <label class="filterLabel ms-2" for="yearTo">—</label>
        <input id="yearTo" type="number" min="1800" max="2026" placeholder="do" style="width:80px" />
    </div>
</div>
<div class="text-center mt-3">
    <input class="btn-brown" type="submit" value="Zobraziť">
</div>

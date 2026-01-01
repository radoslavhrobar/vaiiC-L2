<?php
?>

<h3 class="titleName">Rebríček</h3>
<div class="controls row mt-4">
    <div class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="type">Typ:</label>
        <select id="type" class="select">
            <option value="film">film</option>
            <option value="series">seriál</option>
            <option value="book">kniha</option>
        </select>
    </div>
    <div class="col-lg-4 text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="genre">Žáner: </label>
        <select id="genre" class="select">
            <option value="">-všetky-</option>
        </select>
    </div>
    <div class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2 filter-card">
        <label class="filterLabel" for="yearFrom">Obdobie: </label>
        <input id="yearFrom" type="number" min="1800" max="2100" placeholder="od" style="width:80px" />
        <label class="filterLabel ms-2" for="yearTo">—</label>
        <input id="yearTo" type="number" min="1800" max="2100" placeholder="do" style="width:80px" />
    </div>
</div>
<div class="text-center mt-3">
    <input class="btn-brown" type="submit" value="Zobraziť">
</div>

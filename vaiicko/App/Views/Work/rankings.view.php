<?php
?>

<div class="container">
    <h3>Rebríček</h3>

    <div class="controls row">
        <div class="filter-card">
            <label for="type">Typ: </label>
            <select id="type" class="select">
                <option value="film">film</option>
                <option value="series">seriál</option>
                <option value="book">kniha</option>
            </select>
        </div>

        <div class="filter-card">
            <label for="genre">Žáner: </label>
            <select id="genre" class="select">
                <option value="">-všetky-</option>
            </select>
        </div>

        <div class="filter-card">
            <label for="yearFrom">Obdobie: </label>
            <input id="yearFrom" type="number" min="1800" max="2100" placeholder="od" style="width:80px" />
            <label for="yearTo">—</label>
            <input id="yearTo" type="number" min="1800" max="2100" placeholder="do" style="width:80px" />
        </div>

        <div class="filter-card">
            <button id="applyBtn">Zobraziť</button>
        </div>
    </div>
</div>

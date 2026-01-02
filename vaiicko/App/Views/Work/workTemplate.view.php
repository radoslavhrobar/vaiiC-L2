<?php
/** @var \App\Models\Country[] $countries */
?>

<div class="row">
    <label class="col-sm-3" for="workName">Názov:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="text" name="workName" id="workName" value="<?= $_POST['workName'] ?? '' ?>" autofocus>
    <span id="workNameMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="genre">Žáner:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="genre" id="genre">
        <option value="film">film</option>
        <option value="series">seriál</option>
        <option value="book">kniha</option>
    </select>
    <span id="genreMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="dateOfIssue">Dátum vydania:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="date" name="dateOfIssue" id="dateOfIssue">
    <span id="dateOfIssueMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="placeOfIssue">Miesto vydania:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="placeOfIssue" id="placeOfIssue">
        <?php foreach ($countries as $country): ?>
            <option value="<?= $country->getCode() ?>">
                <?= $country->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
    <span id="placeOfIssueMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="description">Popis:
        <span class="imp">*</span>
    </label>
    <textarea class="col-sm-6" rows="4" name="description" id="description"></textarea>
    <span id="descriptionMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="image">Obrázok:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="file" name="image" id="image" value="<?= $_POST['image'] ?? '' ?>">
    <span id="imageMessage"></span>
</div>

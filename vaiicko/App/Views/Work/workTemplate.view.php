<?php
/** @var \App\Models\Country[] $countries */
/** @var \App\Models\Genre[] $genres */
?>

<div class="row">
    <label class="col-sm-3" for="workName">Názov:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="text" name="workName" id="workName" autofocus>
    <span id="workNameMessage"></span>
</div>
<div class="row">
    <label class="col-sm-3" for="genre">Žáner:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="genre" id="genre">
        <?php foreach ($genres as $genre): ?>
            <option value="<?= $genre->getId() ?>">
                <?= $genre->getName() ?>
            </option>
        <?php endforeach; ?>
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
            <option value="<?= $country->getId() ?>">
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
    <label class="col-sm-3" for="workImage">Náhľad:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="file" name="workImage" id="workImage">
    <span id="workImageMessage"></span>
</div>

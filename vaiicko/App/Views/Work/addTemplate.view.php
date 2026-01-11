<?php
/** @var \App\Models\Country[] $countries */
/** @var \App\Models\Genre[] $genres */
/** @var string $limit */
?>

<div class="row">
    <label class="col-sm-3" for="workName">Názov:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="text" name="workName" id="workName" autofocus>
    <strong id="workNameMessage"></strong>
</div>
<div class="row">
    <label class="col-sm-3" for="genre">Žáner:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="genre" id="genreTemplate">
        <?php foreach ($genres as $genre): ?>
            <option value="<?= $genre->getId() ?>">
                <?= $genre->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row">
    <label class="col-sm-3" for="dateOfIssue">Dátum vydania:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="date" min="<?= "$limit-01-01" ?>" max="<?= date('Y-m-d') ?>" name="dateOfIssue" id="dateOfIssue" required>
    <strong id="dateOfIssueMessage"></strong>
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
    <strong id="placeOfIssueMessage"></strong>
</div>
<div class="row">
    <label class="col-sm-3" for="description">Popis:
        <span class="imp">*</span>
    </label>
    <textarea class="col-sm-6" rows="4" name="description" id="description"></textarea>
    <strong id="descriptionMessage"></strong>
</div>
<div class="row">
    <label class="col-sm-3" for="workImage">Náhľad:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="file" name="image" id="workImage">
    <strong id="workImageMessage"></strong>
</div>

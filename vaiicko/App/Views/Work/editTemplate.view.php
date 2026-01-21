<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\Country[] $countries */
/** @var \App\Models\Genre[] $genres */
/** @var \App\Models\Work $work */
/** @var string $limit */
?>

<input type="hidden" name="id" id="workId" value="<?= (int)$work->getId() ?>">

<div class="row">
    <label class="col-sm-3" for="workName">Názov:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="text" name="workName" id="workName" value="<?= htmlspecialchars($work->getName(), ENT_QUOTES, 'UTF-8') ?>" autofocus>
    <strong id="workNameMessage"></strong>
</div>

<div class="row">
    <label class="col-sm-3" for="genreTemplate">Žáner:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="genre" id="genreTemplate">
        <?php foreach ($genres as $genre): ?>
            <option value="<?= (int)$genre->getId() ?>" <?=  $work->getGenre() == $genre->getId() ? 'selected' : '' ?>>
                <?= htmlspecialchars($genre->getName(), ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="row">
    <label class="col-sm-3" for="dateOfIssue">Dátum vydania:
        <span class="imp">*</span>
    </label>
    <input class="col-sm-6" type="date" min="<?= htmlspecialchars($limit, ENT_QUOTES, 'UTF-8') ?>-01-01" max="<?= date('Y-m-d') ?>" name="dateOfIssue" id="dateOfIssue" value="<?= htmlspecialchars(date('Y-m-d', strtotime($work->getDateOfIssue())), ENT_QUOTES, 'UTF-8') ?>" required>
    <strong id="dateOfIssueMessage"></strong>
</div>

<div class="row">
    <label class="col-sm-3" for="placeOfIssue">Miesto vydania:
        <span class="imp">*</span>
    </label>
    <select class="col-sm-6" name="placeOfIssue" id="placeOfIssue">
        <?php foreach ($countries as $country): ?>
            <option value="<?= (int)$country->getId() ?>" <?=  $work->getPlaceOfIssue() == $country->getId() ? 'selected' : '' ?>>
                <?= htmlspecialchars($country->getName(), ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select>
    <strong id="placeOfIssueMessage"></strong>
</div>

<div class="row">
    <label class="col-sm-3" for="description">Popis:
        <span class="imp">*</span>
    </label>
    <textarea class="col-sm-6" rows="4" name="description" id="description"><?= htmlspecialchars($work->getDescription(), ENT_QUOTES, 'UTF-8') ?></textarea>
    <strong id="descriptionMessage"></strong>
</div>

<div class="row">
    <label class="col-sm-3" for="previousImage">Aktuálny náhľad:</label>
    <div class="col-sm-6">
        <img id="previousImage" src="<?= $link->asset('uploads/works/' . htmlspecialchars($work->getImage(), ENT_QUOTES, 'UTF-8')) ?>" alt="Aktuálny náhľad" class="previousImage">
    </div>
</div>

<div class="row">
    <label class="col-sm-3" for="workImage">Náhľad:</label>
    <input class="col-sm-6" type="file" name="image" id="workImage" accept="image/jpeg,image/png">
    <strong id="workImageMessage"></strong>
</div>

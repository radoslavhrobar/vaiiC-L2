<?php
/** @var \App\Helpers\TypesOfWork[] $types */
/** @var \App\Models\Genre[] $genres */
/** @var \App\Models\Work[] $works */
/** @var \App\Models\Genre[] $genresByIds */
/** @var \App\Models\Country[] $countriesByIds */
/** @var  $workDetails */
/** @var \Framework\Support\LinkGenerator $link */
?>

<form id="workForm" class="forms" action="<?= $link->url("work.rankings") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <h3 class="titleName">Rebríček</h3>
    <div class="filters row mt-4">
        <div class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="typeOfWork">Typ:</label>
            <select name="type"  id="typeOfWork">
                <option value="všetky">-všetky-</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type->name ?>"><?= $type->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="genreRankings">Žáner: </label>
            <select id="genreRankings" name="genre">
                <option value="všetky">-všetky-</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre->getId() ?>"><?= $genre->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2 filter-card">
            <label class="filterLabel" for="yearFrom">Obdobie: </label>
            <input id="yearFrom" type="number" name="yearFrom" value="<?= \App\Helpers\TypesOfWork::minYear() ?>" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="<?= date('Y-m-d') ?>" style="width:80px" />
            <label class="filterLabel ms-2" for="yearTo">—</label>
            <input id="yearTo" type="number" name="yearTo" value="<?= date('Y-m-d') ?>" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="<?= date('Y-m-d') ?>" style="width:80px" />
        </div>
    </div>
    <div class="text-center mt-3">
        <input class="btn-brown" type="submit" value="Zobraziť">
    </div>
</form>
<?php foreach ($works as $i => $work): ?>
    <div class="card mb-1 mx-5 rankingsCard">
        <div class="card-body d-flex gap-3">
    <!--        <img src="poster.jpg"-->
    <!--             class="rounded"-->
    <!--             style="width:70px;height:100px;object-fit:cover;"-->
    <!--             alt="Plagát">-->
            <div class="flex-grow-1">
                <h5 class= "mb-1 fw-bold">
                    <span class="specialColor"><?= $i +1 ?>.</span>
                    <a class="workLink" href="<?= $work->getType() === 'Film' ? $link->url("movieDetail.page", ['id' => $work->getId()]) : ($work->getType() === 'Kniha' ? $link->url("bookDetail.page", ['id' => $work->getId()]) : ($work->getType() === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $work->getId()]) : '#')); ?>">
                        <?= $work->getName() ?></a>
                    <span class="text-secondary fw-normal">(<?= (new DateTime($work->getDateOfIssue()))->format('Y') ?><?= (!isset($_POST['type']) || $_POST['type'] === 'všetky') ? ', ' . $work->getType() : '' ?>)</span>
                </h5>
                <div class="text-secondary fw-bold small mb-2">
                    <?= $countriesByIds[$i]->getName()  ?><?= (!isset($_POST['genre']) || $_POST['genre'] === 'všetky') ? ' • ' . $genresByIds[$i]->getName() : '' ?>
                </div>
                <p class="mb-0 text-secondary small">
                    <?= mb_strimwidth($work->getDescription(), 0, 70, '…') ?>
                </p>
            </div>
            <div class="text-center d-flex flex-column justify-content-center">
                <div class="specialBackgroundColor text-white fw-bold fs-5 px-3 py-2 rounded">
                    sdfsdfds
                </div>
                <div class="text-secondary mt-1">
                    sdfsdf
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script src="<?= $link->asset('js/rankings.js') ?>"></script>

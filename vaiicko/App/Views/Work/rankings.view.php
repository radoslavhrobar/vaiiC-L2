<?php
/** @var \App\Helpers\TypesOfWork[] $types */
/** @var \App\Models\Genre[] $genres */
/** @var $worksToShow */
/** @var \Framework\Support\LinkGenerator $link */
/** @var $ok */
/** @var $totalPages */
/** @var $currentPage */
/** @var $start */
?>

<form id="workForm" class="forms" action="<?= $link->url("work.rankings") ?>" enctype="multipart/form-data" method="post" autocomplete="on">
    <h3 class="titleName">Rebríček</h3>
    <div class="filters row mt-4">
        <div class="col-lg-4 text-lg-end text-center mb-lg-0 mb-2">
            <label class="filterLabel" for="typeOfWork">Typ diela:</label>
            <select name="type" id="typeOfWork">
                <option value="všetky" <?= isset($_REQUEST['type']) && $_REQUEST['type'] === 'všetky' ? 'selected' : '' ?>>-všetky-</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= htmlspecialchars($type->name, ENT_QUOTES, 'UTF-8') ?>" <?= isset($_REQUEST['type']) && $_REQUEST['type'] === $type->name ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type->name, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-center mb-lg-0 mb-2">
            <label class="filterLabel" for="genreRankings">Žáner: </label>
            <select id="genreRankings" name="genre">
                <option value="všetky" <?= isset($_REQUEST['genre']) && $_REQUEST['genre'] === 'všetky' ? 'selected' : '' ?>>-všetky-</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= (int)$genre->getId() ?>" <?= isset($_REQUEST['genre']) && $_REQUEST['genre'] == $genre->getId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre->getName(), ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 text-lg-start text-center mb-lg-0 mb-2">
            <label class="filterLabel" for="yearFrom">Obdobie: </label>
            <input id="yearFrom" type="number" name="yearFrom" value="<?= (int)($_REQUEST['yearFrom'] ?? \App\Helpers\TypesOfWork::minYear()) ?>" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="2026" style="width:80px" />
            <label class="filterLabel ms-2" for="yearTo">—</label>
            <input id="yearTo" type="number" name="yearTo" value="<?= (int)($_REQUEST['yearTo'] ?? 2026) ?>" min="<?= \App\Helpers\TypesOfWork::minYear() ?>" max="2026" style="width:80px" />
        </div>
    </div>
    <div class="text-center mt-3">
        <label class="filterLabel" for="typeOfWork">Zoradiť podľa:</label>
        <select name="order" id="typeOfWork">
            <option value="best" <?= isset($_REQUEST['order']) && $_REQUEST['order'] === 'best' ? 'selected' : '' ?>>najlepšie</option>
            <option value="favorite" <?= isset($_REQUEST['order']) && $_REQUEST['order'] === 'favorite' ? 'selected' : '' ?>>najobľúbenejšie</option>
            <option value="worst" <?= isset($_REQUEST['order']) && $_REQUEST['order'] === 'worst' ? 'selected' : '' ?>>najhoršie</option>
            <option value="newest" <?= isset($_REQUEST['order']) && $_REQUEST['order'] === 'newest' ? 'selected' : '' ?>>najnovšie</option>
        </select>
    </div>
    <div class="text-center mt-4">
        <input id="rankingsBtn" class="btn-brown" type="submit" value="Zobraziť">
    </div>
</form>

<?php if (!$ok) : ?>
    <div class="text-center">
        <strong class="text-danger">Nesprávne údaje pre filtrovanie.</strong>
    </div>
<?php else: ?>
    <?php foreach ($worksToShow as $i => $work): ?>
        <div class="card mb-1 mx-md-5 mx-1 rankingsCard">
            <div class="card-body d-flex gap-3">
                <div>
                    <img src="<?= $link->asset('uploads/works/' . htmlspecialchars($work['image'], ENT_QUOTES, 'UTF-8')) ?>" class="rounded imageRankings" alt="Plagát">
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-1 fw-bold">
                        <span class="specialColor"><?= (int)($start + $i + 1) ?>.</span>
                        <a class="listLink" href="<?= $work['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => (int)$work['id']])
                            : ($work['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => (int)$work['id']])
                                : ($work['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => (int)$work['id']]) : '#')); ?>">
                            <?= htmlspecialchars($work['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <span class="text-secondary fw-normal">(<?= (new DateTime($work['date_of_issue']))->format('Y') ?><?= (!isset($_REQUEST['type']) || $_REQUEST['type'] === 'všetky') ? ', ' . htmlspecialchars($work['type'], ENT_QUOTES, 'UTF-8') : '' ?>)</span>
                    </h5>
                    <div class="text-secondary fw-bold small mb-2">
                        <?= htmlspecialchars($work['country'], ENT_QUOTES, 'UTF-8') ?><?= (!isset($_REQUEST['genre']) || $_REQUEST['genre'] === 'všetky') ? ' • ' . htmlspecialchars($work['genre'], ENT_QUOTES, 'UTF-8') : '' ?>
                    </div>
                    <p class="mb-0 text-secondary small">
                        <?= htmlspecialchars(mb_strimwidth($work['description'], 0, 70, '…'), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                <div class="text-center d-flex flex-column justify-content-center">
                    <?php if ((isset($_REQUEST['order']) && $_REQUEST['order'] !== 'favorite') || !isset($_REQUEST['order'])): ?>
                        <div class="text-white fw-bold fs-5 px-3 py-2 rounded
                        <?= (float)$work['avg_rating'] >= 4.5
                            ? 'first'
                            : ((float)$work['avg_rating'] >= 3.5
                                ? 'second'
                                : ((float)$work['avg_rating'] >= 2.5
                                    ? 'third'
                                    : 'last'
                                )
                            )
                        ?>">
                            <?= $work['avg_rating'] !== null ? round((float)$work['avg_rating'] / 5 * 100, 1) . '%' : '? %' ?>
                        </div>
                        <div class="text-secondary mt-1">
                            <?= (int)($work['rating_count'] ?? 0) ?> hodnotení
                        </div>
                    <?php else: ?>
                        <div class="specialBackgroundColor text-white fw-bold px-3 py-2 rounded">
                            <div class="fs-4">
                                <?= (int)($work['favorites_count'] ?? 0) ?> ❤️
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <?php if ($totalPages > 1): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                        <li class="page-item">
                            <a class="fw-bold specialColor me-2"
                               href="<?= $link->url('work.rankings', array_filter([
                                   'page' => $page,
                                   'type' => $_REQUEST['type'] ?? null,
                                   'genre' => $_REQUEST['genre'] ?? null,
                                   'yearFrom' => $_REQUEST['yearFrom'] ?? null,
                                   'yearTo' => $_REQUEST['yearTo'] ?? null,
                                   'order' => $_REQUEST['order'] ?? null
                               ])) ?>">
                                <?= $page ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script src="<?= $link->asset('js/rankings.js') ?>"></script>

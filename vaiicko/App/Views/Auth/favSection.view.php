<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var array $favoriteWorks */
?>
<?php require __DIR__ . '/page.view.php' ?>

<div class="pageParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Obľúbené diela
        <span class="text-secondary">(<?= count($favoriteWorks) ?>)</span>
    </h4>

    <div class="card pageParts">
        <div class="card-body d-flex flex-row p-3">
            <?php foreach ($favoriteWorks as $i => $favWork): ?>
                <div class="d-flex flex-column align-items-center mx-3">
                    <div>
                        <img src="<?= $link->asset('uploads/works/' . htmlspecialchars($favWork['image'], ENT_QUOTES, 'UTF-8')) ?>"
                             class="rounded imageRankings"
                             alt="Plagát">
                    </div>
                    <div>
                        <a class="listLink" href="<?= $favWork['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => (int)$favWork['id']]) : ($favWork['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => (int)$favWork['id']]) : ($favWork['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => (int)$favWork['id']]) : '#')); ?>">
                            <?= htmlspecialchars($favWork['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


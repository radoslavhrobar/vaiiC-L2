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
                 <div>
                    <div>
                    </div>
                    <div>
                        <a class="listLink" href="<?= $favWork['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $favWork['id']]) : ($favWork['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $favWork['id']]) : ($favWork['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $favWork['id']]) : '#')); ?>"><?= $favWork['name'] ?> </a>
                    </div>
                 </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

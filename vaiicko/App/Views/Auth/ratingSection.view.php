<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var array $worksRatings */
?>
<?php require __DIR__ . '/page.view.php' ?>

<div class="pageParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Hodnotenia
        <span class="text-secondary">(<?= count($worksRatings) ?>)</span>
    </h4>

    <?php foreach ($worksRatings as $i => $workRating): ?>
        <div class="card pageParts mb-3">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <div>
                        <a class="listLink" href="<?= $workRating['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $workRating['id']]) : ($workRating['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $workRating['id']]) : ($workRating['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $workRating['id']]) : '#')); ?>">
                            <?= htmlspecialchars($workRating['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <span class="text-secondary">
                            (<?= (new DateTime($workRating['date_of_issue']))->format('Y') ?>, <?= htmlspecialchars($workRating['type'], ENT_QUOTES, 'UTF-8') ?>)
                        </span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <div class="userRating fw-normal">
                        <?php for ($j = 0; $j < (int)$workRating['rating']; $j++): ?>
                            ★
                        <?php endfor; ?>
                    </div>
                    <div>
                        <?= isset($workRating['updated_at'])
                            ? (new DateTime($workRating['updated_at']))->format('Y-m-d')
                            : (new DateTime($workRating['created_at']))->format('Y-m-d') ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>






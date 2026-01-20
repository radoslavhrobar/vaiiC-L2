<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \App\Models\User $user */
/** @var array $worksReviews */
/** @var \Framework\Core\IAuthenticator $auth */
/** @var $text */
/** @var $color */
?>
<?php require __DIR__ . '/page.view.php' ?>
<div class="pageParts p-4 rounded mb-5">
    <h4 class="fw-bold mb-4">
        Recenzie
        <span class="text-secondary">(<?= count($worksReviews) ?>)</span>
    </h4>
    <div class="text-center mb-2">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <?php foreach ($worksReviews as $i => $workReview): ?>
        <div class="card pageParts mb-3">
            <div class="card-body d-flex flex-row">
                <div class="w-100">
                    <div class="d-flex flex-row justify-content-between mb-2">
                        <div>
                            <a class="listLink" href="<?= $workReview ['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $workReview['id']]) : ($workReview ['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $workReview['id']]) : ($workReview ['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $workReview['id']]) : '#')); ?>"><?= $workReview['name'] ?> </a>
                            <span class="userRating fw-normal">
                                    <?php for ($j = 0; $j < $workReview['rating']; $j++): ?>
                                        ★
                                    <?php endfor; ?>
                                </span>
                            <span class="text-secondary"> (<?= (new DateTime($workReview['date_of_issue']))->format('Y') . ', ' . $workReview['type']?>)</span>
                        </div>
                        <div>
                            <?= isset($workReview['updated_at']) ? (new DateTime($workReview['updated_at']))->format('Y-m-d') : (new DateTime($workReview['created_at']))->format('Y-m-d')   ?>
                        </div>
                    </div>
                    <div>
                        <?= $workReview['body'] ?>
                    </div>
                    <?php if ($auth->isLogged() && $auth->getUser()->getRole() === 'Admin' && $auth->getUser()->getId() !== $user->getId()
                    && $user->getRole() !== 'Admin'): ?>
                        <button
                                type="button"
                                class="bg-danger mt-3 btn-delete"
                                onclick="return confirm('Odstrániť recenziu ku dielu <?= addslashes($workReview['name']) ?>?')
                                        && (window.location.href='<?= $link->url("review.adminDelete", ['id' => $workReview['review_id']]) ?>');">
                            Odstrániť recenziu
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

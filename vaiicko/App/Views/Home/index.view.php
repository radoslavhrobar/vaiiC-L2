<?php
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \Framework\Support\LinkGenerator $link */
/** @var $best */
/** @var $favs */
/** @var $recent */
/** @var $text */
/** @var $color */
?>

<div class="row">
    <div class="text-center mt-2">
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <div class="col-md-5">
        <div id="carouselExample" class="carousel slide main-carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= $link->asset('images/avatarFire.jpg') ?>" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="<?= $link->asset('images/peakyBlinders.jpg') ?>" class="d-block w-100" alt="">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card registration-info">
            <div class="card-body">
                <h4 class="card-title mb-4">
                        <?php if ($auth->isLogged()) : ?>
                            <i class="bi bi-arrow-right-square"></i>
                            <span class="logged-in-info">Prihlásený ako: <?= $auth->getUser()->getUsername() ?></span>
                        <?php else : ?>
                            <a href="<?= $link->url("auth.registration") ?>" class="text-decoration-none">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Registruj sa na C&L!
                            </a>
                        <?php endif; ?>
                </h4>

                <ul class="list-unstyled mb-4">
                    <li class="mb-2">
                        <i class="bi-film me-2"></i>
                        Prehľad rebríčkov diel kinematografie a literatúry
                        <i class="bi bi-book-half ms-2"></i>
                    </li>
                    <li class="mb-2">
                        <i class= "bi-megaphone me-2"></i>
                        Pridávaj recenzie k dielam, ktoré ťa zaujali
                    </li>
                    <li >
                        <i class="bi-person me-2"></i>
                        Preskúmavaj profily iných používateľov
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-6">
                <div class="card mainPageRankings mx-sm-0 mx-4 mb-3">
                    <div class="card-body">
                        <h5 class="text-center mb-3 border-bottom pb-2">
                            <i class="bi bi-star-fill text-danger"></i> Najlepšie diela
                        </h5>
                        <?php foreach ($best as $work): ?>
                            <div class="d-flex align-items-center justify-content-center mb-3 gap-3">
                                <img src="<?= $link->asset('uploads/works/' . $work['image']) ?>" class="rounded imageRankings" alt="Plagát">
                                <div class="text-center top3 d-flex flex-column gap-1">
                                    <div class="fw-bold text-center"><a class="listLink" href="<?= $work['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $work['id']]) : ($work['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $work['id']]) : ($work['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $work['id']]) : '#')); ?>">
                                            <?= $work['name'] ?></a></div>
                                    <div class="text-white px-3 py-2 rounded fs-4 fw-bold text-center <?= $work['avg_rating'] >= 4.5
                                        ? 'first'
                                        : ($work['avg_rating'] >= 3.5
                                            ? 'second'
                                            : ($work['avg_rating'] >= 2.5
                                                ? 'third'
                                                : 'last'
                                            )
                                        )
                                    ?>">
                                            <?= $work['avg_rating'] !== null ? $work['avg_rating'] / 5 * 100 . '%' : '? %' ?>
                                    </div>
                                    <div class="text-center text-danger fw-bold">
                                        <?= $work['rating_count'] ?? '0' ?> hodnotení
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card mainPageRankings mx-sm-0 mx-4 mb-3">
                    <div class="card-body">
                        <h5 class="text-center mb-3 border-bottom pb-2">
                            ❤️ Najobľúbenejšie diela
                        </h5>
                        <?php foreach ($favs as $work): ?>
                            <div class="d-flex align-items-center justify-content-center mb-3 gap-md-3">
                                <img src="<?= $link->asset('uploads/works/' . $work['image']) ?>" class="rounded imageRankings" alt="Plagát">
                                <div class="text-center top3 d-flex flex-column gap-1">
                                    <div class="fw-bold text-center"><a class="listLink" href="<?= $work['type'] === 'Film' ? $link->url("movieDetail.page", ['id' => $work['id']]) : ($work['type'] === 'Kniha' ? $link->url("bookDetail.page", ['id' => $work['id']]) : ($work['type'] === 'Seriál' ? $link->url("seriesDetail.page", ['id' => $work['id']]) : '#')); ?>">
                                            <?= $work['name'] ?></a></div>
                                    <div class="specialBackgroundColor text-white px-3 py-2 rounded">
                                        <div class="fs-4 text-center fw-bold">
                                            <?= $work['favorites_count'] ?? '0' ?>❤️
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

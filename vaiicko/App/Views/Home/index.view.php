<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="row">
    <div class="col-md-6">
        <div id="carouselExample" class="carousel slide main-carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= $link->asset('images/kinoALiteratura1.jpg') ?>" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="<?= $link->asset('images/kinoALiteratura2.png') ?>" class="d-block w-100" alt="">
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

    <div class="col-md-6">
        <div class="card registration-info">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <a href="#" class="text-decoration-none">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Registruj sa na C&L!
                    </a>
                </h4>

                <ul class="list-unstyled mb-4">
                    <li class="mb-2">
                        <i class="bi-film me-2"></i>
                        Prehľad oblasti kinematografie a literatúry
                        <i class="bi bi-book-half ms-2"></i>
                    </li>
                    <li class="mb-2">
                        <i class= "bi-megaphone me-2"></i>
                        Pridávaj recenzie k dielam, ktoré ťa zaujali
                    </li>
                    <li >
                        <i class="bi-person me-2"></i>
                        Spoj sa s ľuďmi, ktorí zdieľajú tvoju vášeň pre diela
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

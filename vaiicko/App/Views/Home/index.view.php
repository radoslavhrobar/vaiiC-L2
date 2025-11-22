<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="row">
    <div class="col-6">
        <!-- komponent carousel prevziaty z bootstrapu -->
        <div id="carouselExample" class="carousel slide hlavny-carousel">
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

    <div class="col-6">
        <table class="registracia-info">
            <tr>
                <th>
                    <a href="#">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Registruj sa na C&L!
                    </a>
                </th>
            </tr>
            <tr>
                <td>
                    <i class="bi bi-film"></i>
                    Prehľad oblasti kinematografie a literatúry
                    <i class="bi bi-book-half"></i>
                </td>
            </tr>
            <tr>
                <td>
                    <i class="bi bi-megaphone"></i>
                    Pridávaj recenzie k dielam, ktoré ťa zaujali
                </td>
            </tr>
            <tr>
                <td>
                    <i class="bi bi-person"></i>
                    Spoj sa s ľuďmi, ktorí zdieľajú tvoju vášeň pre diela
                </td>
            </tr>
        </table>
    </div>
</div>

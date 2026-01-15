<?php

/** @var string $contentHTML */
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= App\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 background-left d-none d-xl-block"></div>
        <div class="col-xl-8">
            <nav class="navbar navbar-expand-md bg-body-tertiary">
                <a class="navbar-brand" href="<?= $link->url("home.index") ?>">C&L</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= $link->url("work.index") ?>">Novinky</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= $link->url("work.rankings") ?>">Rebríčky</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Zaujímavosti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= $link->url("auth.all") ?>">Používatelia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= $link->url("movieDetail.add") ?>">Pridanie diela</a>
                        </li>
                    </ul>
                    <div class="nav-item dropdown me-2 mb-2 mb-md-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Môj účet
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($auth->isLogged()) { ?>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.page") ?>">Môj profil</a></li>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.logout") ?>">Odhlásiť sa</a></li>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.edit") ?>">Zmeniť údaje</a></li>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.delete") ?>"
                                       onclick="return confirm('Naozaj chceš zmazať svoj účet?')">Zmazať účet</a></li>
                            <?php } else { ?>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.index") ?>">Prihlásenie</a></li>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.registration") ?>">Registrácia</a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <form class="d-flex" role="search">
                        <div class="position-relative">
                            <input id="searchInput" class="form-control me-2" type="search" placeholder="Hľadať dielo..." autocomplete="off">
                            <div id="searchResults" class="list-group position-absolute w-100 mt-1" style="z-index:1000"></div>
                        </div>
                    </form>
                </div>
            </nav>
            <div class="web-content">
                <?= $contentHTML ?>
            </div>
        </div>
        <div class="col-xl-2 background-right d-none d-xl-block"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
<script src="<?= $link->asset('js/search.js') ?>"></script>

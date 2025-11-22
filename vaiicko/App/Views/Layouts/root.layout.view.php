<?php

/** @var string $contentHTML */
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 pozadie-vlavo d-none d-xl-block"></div>
        <div class="col-xl-8">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <a class="navbar-brand" href="<?= $link->url("home.index") ?>">C&L</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= $link->url("home.kino") ?>">Kino</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Literatúra</a>
                        </li>
                    </ul>
                    <div class="nav-item dropdown moj-ucet">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Môj účet
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($auth->isLogged()) { ?>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.logout") ?>">Odhlásenie</a></li>
                            <?php } else { ?>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.login") ?>">Prihlásenie</a></li>
                                <li><a class="dropdown-item" href="<?= $link->url("auth.index") ?>">Registrácia</a></li>
                                <li><a class="dropdown-item" href="#">Zabudnuté heslo</a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Hľadať" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </nav>
            <div class="web-content">
                <?= $contentHTML ?>
            </div>
        </div>
        <div class="col-xl-2 pozadie-vpravo d-none d-xl-block"></div>
    </div>
</div>
</body>
</html>

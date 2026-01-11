<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
/** @var string $text */
/** @var string $color*/

?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
                    </div>
                    <h5 class="titleName mt-0">Prihlásenie</h5>
                    <div class="text-center text-danger mb-3">
                        <strong><?= @$message ?></strong>
                    </div>
                    <form class="form-signin" method="post" action="<?= $link->url("auth.login") ?>">
                        <div class="form-label-group mb-3">
                            <label for="username" class="form-label">Používateľské meno:</label>
                            <input name="username" type="text" id="username" class="form-control" required autofocus>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Heslo:</label>
                            <input name="password" type="password" id="password" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button class="btn-brown" type="submit" name="submit">Prihlásiť sa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/** @var \Framework\Support\LinkGenerator $link*/
/** @var string $text */
/** @var string $color*/
?>

<form id="registration" class="forms formsOrganized" action="<?= $link->url("auth.register") ?>" method="post" autocomplete="on">
    <h4 class="titleName">Registrácia</h4>

    <div class="row">
        <label class="col-sm-3" for="email">Email:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" autofocus>
        <strong id="emailMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="usernameMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="password">Heslo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="password" id="password" value="<?= htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="passwordMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="<?= htmlspecialchars($_POST['verifyPassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="verifyPasswordMessage"></strong>
    </div>

    <h5 class="titleName extra">Dodatočné informácie:</h5>

    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="nameMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname" value="<?= htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="surnameMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="hidden" name="gender" value="">
            <input type="radio" name="gender" id="gender" value="Male" <?= isset($_POST['gender']) && $_POST['gender'] === 'Male' ? 'checked'  : '' ?>> muž
            <input type="radio" name="gender" id="gender" value="Female"  <?= isset($_POST['gender']) && $_POST['gender'] === 'Female' ? 'checked' : '' ?>> žena
            <input type="radio" name="gender" id="gender" value="Other"  <?= isset($_POST['gender']) && $_POST['gender'] === 'Other' ? 'checked' : '' ?>> iné
        </div>
        <strong class="<?= isset($color) ? "text-" . htmlspecialchars($color, ENT_QUOTES, 'UTF-8') : '' ?>">
            <?= htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8') ?>
        </strong>
    </div>

    <div class="text-center">
        <input class="btn-brown" type="submit" value="Zaregistrovať">
    </div>
</form>

<script src="<?= $link->asset('js/auth.js') ?>"></script>

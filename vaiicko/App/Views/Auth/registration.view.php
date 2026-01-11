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
        <input class="col-sm-6" type="text" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" autofocus>
        <strong id="emailMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>">
        <strong id="usernameMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="password">Heslo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>">
        <strong id="passwordMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="<?= $_POST['verifyPassword'] ?? '' ?>">
        <strong id="verifyPasswordMessage"></strong>
    </div>
    <h5 class="titleName extra">Dodatočné informácie:</h5>
    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>">
        <strong id="nameMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname" value="<?= $_POST['surname'] ?? '' ?>">
        <strong id="surnameMessage"></strong>
    </div>
    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="hidden" name="gender" value="">
            <input type="radio" name="gender" id="gender" value="Male" <?= isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked'  : '' ?>>muž
            <input type="radio" name="gender" id="gender" value="Female"  <?= isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : '' ?>>žena
            <input type="radio" name="gender" id="gender" value="Other"  <?= isset($_POST['gender']) && $_POST['gender'] == 'Other' ? 'checked' : '' ?>>iné
        </div>
        <strong class="<?= isset($color) ? "text-$color" : '' ?>"><?= $text ?? '' ?></strong>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Zaregistrovať">
    </div>
</form>
<script src="<?= $link->asset('js/auth.js') ?>"></script>


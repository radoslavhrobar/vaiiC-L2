<?php
/** @var array $data */
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="registration" class="registration" action="<?= $link->url("auth.register") ?>" method="post" autocomplete="on">
    <h4 class="auth-name">Registrácia</h4>
    <div class="row">
        <label class="col-sm-3" for="email">Email:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" autofocus>
        <span id="emailMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>">
        <span id="usernameMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="password">Heslo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>">
        <span id="passwordMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="<?= $_POST['verifyPassword'] ?? '' ?>">
        <span id="verifyPasswordMessage"></span>
    </div>
    <h5 class="auth-name extra">Dodatočné informácie:</h5>
    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>">
        <span id="nameMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname" value="<?= $_POST['surname'] ?? '' ?>">
        <span id="surnameMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="hidden" name="gender" value="">
            <input type="radio" name="gender" id="gender" value="Male" <?= isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked'  : '' ?>>muž
            <input type="radio" name="gender" id="gender" value="Female"  <?= isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : '' ?>>žena
            <input type="radio" name="gender" id="gender" value="Other"  <?= isset($_POST['gender']) && $_POST['gender'] == 'Other' ? 'checked' : '' ?>>iné
        </div>
        <span><?= $message ?? '' ?></span>
    </div>
    <div class="text-center">
        <input class="btn--brown" type="submit" value="Zaregistrovať">
    </div>
</form>


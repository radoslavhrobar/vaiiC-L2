<?php
/** @var \Framework\Support\LinkGenerator $link */
?>

<form id="user-edit" class="forms" action="<?= $link->url('auth.update') ?>" method="post" autocomplete="on">
    <h4 class="auth-name">Upraviť profil</h4>
    <div class="row">
        <label class="col-sm-3" for="email">Email:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" required>
        <span id="emailMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>" required>
        <span id="usernameMessage"></span>
    </div>
    <h5 class="auth-name extra">Zmena hesla</h5>
    <div class="row">
        <label class="col-sm-3" for="currentPassword">Aktuálne heslo:</label>
        <input class="col-sm-6" type="password" name="currentPassword" id="currentPassword" value="">
        <span id="currentPasswordMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="password">Nové heslo:</label>
        <input class="col-sm-6" type="password" name="password" id="password" value="">
        <span id="passwordMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:</label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="">
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
            <input type="radio" name="gender" id="gender_male" value="Male" <?=  isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked'  : ''  ?>> muž
            <input type="radio" name="gender" id="gender_female" value="Female" <?= isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : '' ?>> žena
            <input type="radio" name="gender" id="gender_other" value="Other" <?= isset($_POST['gender']) && $_POST['gender'] == 'Other' ? 'checked' : '' ?>> iné
        </div>
        <span><?= $message ?? '' ?></span>
    </div>
    <div class="text-center">
        <input class="btn--brown" type="submit" value="Uložiť zmeny">
    </div>
</form>

<?php
/** @var \App\Models\User $user */
/** @var \Framework\Support\LinkGenerator $link */
?>

<form id="user-edit" class="forms" action="<?= $link->url('auth.update') ?>" method="post" autocomplete="on">
    <input type="hidden" name="id" id="user-id" value="<?= isset($user) ? $user->getId() : $_POST['id'] ?>">
    <h4 class="auth-name">Upravenie profilu</h4>
    <div class="row">
        <label class="col-sm-3" for="email">Email:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="email" id="email" value="<?= isset($user) ? $user->getEmail() : $_POST['email']?>" autofocus>
        <span id="emailMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= isset($user) ? $user->getUsername() : $_POST['username'] ?>">
        <span id="usernameMessage"></span>
    </div>
    <h5 class="auth-name extra">Zmena hesla</h5>
    <div class="row">
        <label class="col-sm-3" for="currentPassword">Aktuálne heslo:</label>
        <input class="col-sm-6" type="password" name="currentPassword" id="currentPassword" value="<?= $_POST['currentPassword'] ?? '' ?>">
        <span id="currentPasswordMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="password">Nové heslo:</label>
        <input class="col-sm-6" type="password" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>">
        <span id="passwordMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:</label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="<?= $_POST['verifyPassword'] ?? '' ?>">
        <span id="verifyPasswordMessage"></span>
    </div>
    <h5 class="auth-name extra">Dodatočné informácie:</h5>
    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name" value="<?= isset($user) ? $user->getName() : $_POST['name'] ?>">
        <span id="nameMessage"></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname" value="<?= isset($user) ? $user->getSurname() : $_POST['surname'] ?>">
        <span id="surnameMessage"></span>
    </div>
    <?php $selectedGender = isset($user) ? $user->getGender() : $_POST['gender'] ?>
    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="hidden" name="gender" value="">
            <input type="radio" name="gender" id="gender" value="Male" <?= ($selectedGender === 'Male') ? 'checked' : '' ?>> muž
            <input type="radio" name="gender" id="gender" value="Female" <?= ($selectedGender === 'Female') ? 'checked' : '' ?>> žena
            <input type="radio" name="gender" id="gender" value="Other" <?= ($selectedGender === 'Other') ? 'checked' : '' ?>> iné
        </div>
        <span><?= $message ?? '' ?></span>
    </div>
    <div class="text-center">
        <input class="btn-brown" type="submit" value="Uložiť zmeny">
    </div>
</form>

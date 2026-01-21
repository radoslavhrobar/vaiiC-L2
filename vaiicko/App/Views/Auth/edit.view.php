<?php
/** @var \App\Models\User $user */
/** @var \Framework\Support\LinkGenerator $link */
/** @var string $text */
/** @var string $color*/
?>

<form id="user-edit" class="forms formsOrganized" action="<?= $link->url('auth.update') ?>" method="post" autocomplete="on">
    <input type="hidden" name="id" id="user-id"
           value="<?= isset($user) ? (int)$user->getId() : (int)($_POST['id'] ?? 0) ?>">

    <h4 class="titleName">Upravenie profilu</h4>

    <div class="row">
        <label class="col-sm-3" for="email">Email: <span class="imp">*</span></label>
        <input class="col-sm-6" type="text" name="email" id="email"
               value="<?= htmlspecialchars(isset($user) ? $user->getEmail() : ($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" autofocus>
        <strong id="emailMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno: <span class="imp">*</span></label>
        <input class="col-sm-6" type="text" name="username" id="username"
               value="<?= htmlspecialchars(isset($user) ? $user->getUsername() : ($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <strong id="usernameMessage"></strong>
    </div>

    <h5 class="titleName extra">Zmena hesla</h5>

    <div class="row">
        <label class="col-sm-3" for="currentPassword">Aktuálne heslo:</label>
        <input class="col-sm-6" type="password" name="currentPassword" id="currentPassword"
               value="<?= htmlspecialchars($_POST['currentPassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="currentPasswordMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="password">Nové heslo:</label>
        <input class="col-sm-6" type="password" name="password" id="password"
               value="<?= htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="passwordMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:</label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword"
               value="<?= htmlspecialchars($_POST['verifyPassword'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <strong id="verifyPasswordMessage"></strong>
    </div>

    <h5 class="titleName extra">Dodatočné informácie:</h5>

    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name"
               value="<?= htmlspecialchars(isset($user) ? $user->getName() : ($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <strong id="nameMessage"></strong>
    </div>

    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname"
               value="<?= htmlspecialchars(isset($user) ? $user->getSurname() : ($_POST['surname'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <strong id="surnameMessage"></strong>
    </div>

    <?php $selectedGender = isset($user) ? $user->getGender() : ($_POST['gender'] ?? '') ?>

    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="hidden" name="gender" value="">
            <input type="radio" name="gender" value="Male"   <?= $selectedGender === 'Male'   ? 'checked' : '' ?>> muž
            <input type="radio" name="gender" value="Female" <?= $selectedGender === 'Female' ? 'checked' : '' ?>> žena
            <input type="radio" name="gender" value="Other"  <?= $selectedGender === 'Other'  ? 'checked' : '' ?>> iné
        </div>
        <strong class="<?= isset($color) ? "text-$color" : '' ?>">
            <?= htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8') ?>
        </strong>
    </div>

    <div class="text-center">
        <input class="btn-brown" type="submit" value="Uložiť zmeny">
    </div>
</form>
<script src="<?= $link->asset('js/auth.js') ?>"></script>
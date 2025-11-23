<?php
/** @var Array $data */
/** @var \Framework\Support\LinkGenerator $link*/
?>

<form id="registration" class="registration" action="<?= $link->url("auth.register") ?>" method="post" autocomplete="on">
    <h4 class="auth-name">Registrácia</h4>
    <div class="row">
        <label class="col-sm-3" for="email">Email:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="email" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" autofocus>
        <span id="emailMessage"><?= !empty($data['warnings']['email']) ? $data['warnings']['email'] : "" ?></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="username">Používateľské meno:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>">
        <span id="usernameMessage"><?= !empty($data['warnings']['username']) ? $data['warnings']['username'] : "" ?></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="password">Heslo:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>">
        <span id="passwordMessage"><?= !empty($data['warnings']['password']) ? $data['warnings']['password'] : "" ?></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="verifyPassword">Overenie hesla:
            <span class="imp">*</span>
        </label>
        <input class="col-sm-6" type="password" name="verifyPassword" id="verifyPassword" value="<?= $_POST['verifyPassword'] ?? '' ?>">
        <span id="verifyPasswordMessage"><?= !empty($data['warnings']['verifyPassword']) ? $data['warnings']['verifyPassword'] : "" ?></span>
    </div>
    <h5 class="auth-name extra">Dodatočné informácie:</h5>
    <div class="row">
        <label class="col-sm-3" for="name">Meno:</label>
        <input class="col-sm-6" type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>">
        <span id="nameMessage"><?= !empty($data['warnings']['name']) ? $data['warnings']['name'] : "" ?></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="surname">Priezvisko:</label>
        <input class="col-sm-6" type="text" name="surname" id="surname" value="<?= $_POST['surname'] ?? '' ?>">
        <span id="surnameMessage"><?= !empty($data['warnings']['surname']) ? $data['warnings']['surname'] : "" ?></span>
    </div>
    <div class="row">
        <label class="col-sm-3" for="gender">Pohlavie:</label>
        <div class="col-sm-6">
            <input type="radio" name="gender" id="gender" value="man" <?= isset($_POST['gender']) && $_POST['gender'] == 'man' ? 'checked' : '' ?>>muž
            <input type="radio" name="gender" id="gender" value="female"  <?= isset($_POST['gender']) && $_POST['gender'] == 'female' ? 'checked' : '' ?>>žena
            <input type="radio" name="gender" id="gender" value="other"  <?= isset($_POST['gender']) && $_POST['gender'] == 'other' ? 'checked' : '' ?>>iné
        </div>
        <span><?= !empty($data['warnings']['gender']) ? $data['warnings']['gender'] : "" ?></span>
    </div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" value="Zaregistrovať">
    </div>
</form>


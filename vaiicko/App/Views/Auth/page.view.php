<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var \Framework\Core\IAuthenticator $auth */
/** @var \App\Models\User $user */
/** @var $favGenres */
/** @var $percentages */
/** @var $whichActive */
?>
<div class="baseInfoRow row rounded mx-2 my-3 p-3 border">
    <div class="col-md-6 userInfoCol rounded p-3">
        <h3 class="fw-bold mb-3"><?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?></h3>

        <div>
            <?= $user->getName() !== null
                ? 'Meno: <strong>' . htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8')
                . ' ' . htmlspecialchars($user->getSurname() ?? '', ENT_QUOTES, 'UTF-8')
                . '</strong>'
                : '' ?>
        </div>

        <div>
            Email: <strong><?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?></strong>
        </div>

        <div>
            <?= $user->getGender() !== null
                ? 'Pohlavie: <strong>' . htmlspecialchars(\App\Helpers\Gender::valueFrom($user->getGender()), ENT_QUOTES, 'UTF-8') . '</strong>'
                : '' ?>
        </div>

        <div>
            Na C&L od: <strong><?= (new DateTime($user->getCreatedAt()))->format('Y-m-d') ?></strong>
        </div>
    </div>

    <div class="col-md-6 mt-md-0 mt-3">
        <h5 class="fw-bold">Najobľúbenejšie žánre:</h5>

        <?php if (!empty($favGenres)): ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($favGenres as $i => $genre): ?>
                    <div>
                        <div class="mb-1">
                            <strong><?= htmlspecialchars($genre['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                        </div>
                        <div class="progress">
                            <div class="bg-warning" style="width: <?= $percentages[$i] ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else:
            if ($auth->isLogged() && $auth->getUser()->getId() == $user->getId()) : ?>
                <p class="text-muted">Zatiaľ nemáš žiadne obľúbené žánre.</p>
            <?php else : ?>
                <p class="text-muted">Používateľ zatiaľ nemá obľúbené žánre.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="btn-group w-100 mb-4">
    <button class="btn btnUserPage <?= htmlspecialchars($whichActive === 'reviews' ? 'active' : '', ENT_QUOTES, 'UTF-8') ?>"
            onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'reviews']) ?>'">
        📝 Recenzie
    </button>
    <button class="btn btnUserPage <?= htmlspecialchars($whichActive === 'ratings' ? 'active' : '', ENT_QUOTES, 'UTF-8') ?>"
            onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'ratings']) ?>'">
        <i class="bi bi-star-fill text-danger"></i> Hodnotenia
    </button>
    <button class="btn btnUserPage <?= htmlspecialchars($whichActive === 'favs' ? 'active' : '', ENT_QUOTES, 'UTF-8') ?>"
            onclick="window.location.href='<?= $link->url("auth.page", ['id' => $user->getId(), 'tab' => 'favorites']) ?>'">
        ❤️ Obľúbené diela
    </button>
</div>

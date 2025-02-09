<?php

/* @var array $apiData */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of users GitHub</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Users</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($apiData)) : ?>
            <div class="list-group">
                <?php foreach ($apiData as $user) : ?>
                    <a href="<?= $user['html_url'] ?>" target="_blank" class="list-group-item d-flex align-items-center">
                        <img src="<?= $user['avatar_url'] ?>" alt="Avatar" class="rounded-circle" width="50" height="50" style="margin-right: 15px;">
                        <div>
                            <strong><?= $user['login'] ?></strong>
                            <br>
                            <small>Go to profile</small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No data received from API.</p>
        <?php endif; ?>
    </div>
</div>


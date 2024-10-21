<?php

use backend\model\Admin;

/* @var Admin $admin */
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="/admin/login" method="post">
            <div class="input-group mb-3">
                <input type="email"
                       name="email"
                       class="form-control <?= $admin->hasError('email') ? 'in-valid' : 'is-invalid' ?>"
                       placeholder="Email"
                       value="<?= $admin->getEmail() ?? '' ?>">
                <?php if ($admin->hasError('email')) : ?>
                    <div class="invalid-feedback"><?= $admin->getError('email') ?></div>
                <?php endif; ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password"
                       name="password"
                       class="form-control <?= $admin->hasError('password') ? 'in-valid' : 'is-invalid' ?>"
                       placeholder="Password">
                <?php if ($admin->hasError('password')) : ?>
                    <div class="invalid-feedback"><?= $admin->getError('password') ?></div>
                <?php endif; ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </div>
        </form>
        <p class="mb-0">
            <a href="/admin/register" class="text-center">Register a new membership</a>
        </p>
    </div>
</div>


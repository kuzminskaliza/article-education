<?php

use backend\model\Admin;

/* @var Admin $admin */
?>
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="/admin/register" method="post">
                <div class="input-group mb-3">
                    <input type="text"
                           name="name"
                           class="form-control <?= $admin->hasError('name') ? 'is-invalid' : 'is-valid' ?>"
                           placeholder="Full name"
                           value="<?= $admin->getName() ?? '' ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <?php if ($admin->hasError('name')) : ?>
                        <div class="invalid-feedback">
                            <?= $admin->getError('name') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           class="form-control <?= $admin->hasError('email') ? 'is-invalid' : 'is-valid' ?>"
                           placeholder="Email"
                           value="<?= $admin->getEmail() ?? '' ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <?php if ($admin->hasError('email')) : ?>
                        <div class="invalid-feedback">
                            <?= $admin->getError('email') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control <?= $admin->hasError('password') ? 'is-invalid' : 'is-valid' ?>"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <?php if ($admin->hasError('password')) : ?>
                        <div class="invalid-feedback">
                            <?= $admin->getError('password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password"
                           name="confirm_password"
                           class="form-control  <?= $admin->hasError('confirm_password') ? 'is-invalid' : 'is-valid' ?>"
                           placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <?php if ($admin->hasError('confirm_password')) : ?>
                        <div class="invalid-feedback">
                            <?= $admin->getError('confirm_password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>
            <a href="/admin/login" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>

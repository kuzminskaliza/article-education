<?php

use backend\model\Admin;

/* @var Admin $admin */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>New Password</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a class="btn btn-block btn-info" href="/admin/view">Back</a>
                            </h3>
                        </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="post" action="/admin/password">
                                    <div class="form-group row">
                                        <label for="inputOldPassword" class="col-sm-2 col-form-label">Old Password</label>
                                        <div class="col-sm-10">
                                            <input
                                                    name="old_password"
                                                    type="password"
                                                    class="form-control <?= $admin->hasError('old_password') ? 'is-invalid' : 'is-valid' ?>"
                                                    id="inputOldPassword">
                                            <?php if ($admin->hasError('old_password')) : ?>
                                                <div class="invalid-feedback"><?= $admin->getError('old_password') ?></div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                                        <div class="col-sm-10">
                                            <input
                                                    name="new_password"
                                                    type="password"
                                                    class="form-control <?= $admin->hasError('new_password') ? 'is-invalid' : 'is-valid' ?>"
                                                    id="inputNewPassword">
                                            <?php if ($admin->hasError('new_password')) : ?>
                                                <div class="invalid-feedback"><?= $admin->getError('new_password') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                                        <div class="col-sm-10">
                                            <input
                                                    name="confirm_password"
                                                    type="password"
                                                    class="form-control <?= $admin->hasError('confirm_password') ? 'is-invalid' : 'is-valid' ?>"
                                                    id="inputConfirmPassword">
                                            <?php if ($admin->hasError('confirm_password')) : ?>
                                                <div class="invalid-feedback"><?= $admin->getError('confirm_password') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-warning">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

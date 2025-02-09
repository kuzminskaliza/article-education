<?php

use backend\model\Admin;

/* @var Admin $admin */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="profile-photo">
                                <?php if ($admin->getPhoto()) : ?>
                                    <img src="<?= $admin->getPhoto() ?>" alt="Admin Photo"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <h3 class="profile-username text-center">
                        </h3>
                        <form action="/admin/view" method="post" enctype="multipart/form-data">
                            <div class="custom-file">
                                <input type="file" id="file" name="file" class="custom-file-input">
                                <label class="custom-file-label" for="file">Choose File</label>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fas fa-download" style="margin-right: 10px;"></i>Download
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings"
                                                    data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" action="/admin/view" method="post">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input
                                                    type="text"
                                                    name="name"
                                                    class="form-control <?= $admin->hasError('name') ? 'is-invalid' : 'is-valid' ?>"
                                                    id="inputName"
                                                    value="<?= $admin->getName() ?? '' ?>">

                                            <?php if ($admin->hasError('name')) : ?>
                                                <div class="invalid-feedback"><?= $admin->getError('name') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input
                                                    name="email"
                                                    type="email"
                                                    class="form-control <?= $admin->hasError('email') ? 'is-invalid' : 'is-valid' ?>"
                                                    id="inputEmail"
                                                    value="<?= $admin->getEmail() ?? '' ?>">
                                            <?php if ($admin->hasError('email')) : ?>
                                                <div class="invalid-feedback"><?= $admin->getError('email') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-warning">Submit</button>
                                            <a href="/admin/password" type="submit" class="btn btn-danger">Forgot password?</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
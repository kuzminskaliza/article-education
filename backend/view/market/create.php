<?php

use backend\model\Market;

/* @var Market $market */

?>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Створення продавця</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>



<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/market/index" class="btn btn-block btn-info">Назад</a>
        </h3>
    </div>
    <div class="card-body">
        <form action="/market/create" method="post">
            <div class="form-group">
                <label for="inputName">Title</label>
                <input
                        type="text"
                        id="inputName"
                        class="form-control <?= $market->hasError('title') ? 'is-invalid' : 'is-valid' ?>"
                        name="title"
                        value="<?= $market->getTitle() ?>"
                >
                <?php if($market->hasError('title')): ?>
                    <span class="error invalid-feedback"><?= $market->getError('title') ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea id="inputDescription" class="form-control" rows="4" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus"
                        class="form-control custom-select <?= $market->hasError('status') ? 'is-invalid' : 'is-valid' ?>"
                        name="status">
                    <option selected="" disabled="">Select one</option>
                    <option>On Hold</option>
                    <option>Canceled</option>
                    <option>Success</option>
                </select>
                <?php if($market->hasError('status')): ?>
                    <span class="error invalid-feedback"><?= $market->getError('status') ?></span>
                <?php endif; ?>

            </div>
            <div class="form-group">
                <label for="inputClientCompany">Company</label>
                <input type="text" id="inputClientCompany" class="form-control" name="company">
            </div>

            <div class="form-group">
                <input type="submit" value="Створити" class="btn btn-success">
            </div>
        </form>
    </div>
</div>


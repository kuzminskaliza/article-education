<?php

use backend\model\ArticleStatus;

/* @var ArticleStatus $status */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Creating of Statuses</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/status/index" class="btn btn-block btn-info">Back</a>
        </h3>
    </div>
    <div class="card-body">
        <form action="/status/create" method="post">
            <div class="form-group">
                <label for="inputName">Title of the status</label>
                <input
                        type="text"
                        id="inputName"
                        class="form-control <?= $status->hasError('title') ? 'is-invalid' : 'is-valid' ?>"
                        name="title"
                        value="<?= $status->getTitle() ?? '' ?>">

                <?php if ($status->hasError('title')) : ?>
                    <div class="invalid-feedback">
                        <?= $status->getError('title') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-success">
            </div>
        </form>
    </div>
</div>
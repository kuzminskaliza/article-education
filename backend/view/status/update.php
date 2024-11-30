<?php

use backend\model\ArticleStatus;

/** @var ArticleStatus $status */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Status</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">
        <form action="/status/update?id=<?= $status->getId() ?>" method="post">
            <div class="form-group">
                <label for="inputName">Status Name</label>
                <input
                    type="text"
                    id="inputName"
                    class="form-control <?= $status->hasError('title') ? 'is-invalid' : '' ?>"
                    name="title"
                    value="<?= $status->getTitle() ?? '' ?>">
                <?php if ($status->hasError('title')) : ?>
                    <div class="invalid-feedback">
                        <?= $status->getError('title') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" value="Update" class="btn btn-success">
                <a href="/status/index" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

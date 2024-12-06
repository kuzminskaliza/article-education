<?php

use backend\model\Category;

/* @var Category $category */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Creating categories</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/category/index" class="btn btn-block btn-info">Back</a>
        </h3>
    </div>
    <div class="card-body">
        <form action="/category/create" method="post">
            <div class="form-group">
                <label for="inputName">Category name</label>
                <input
                    type="text"
                    id="inputName"
                    class="form-control <?= $category->hasError('name') ? 'is-invalid' : 'is-valid' ?>"
                    name="name"
                    value="<?= $category->getName() ?? '' ?>">

                <?php if ($category->hasError('name')) : ?>
                    <div class="invalid-feedback">
                        <?= $category->getError('name') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-success">
            </div>
        </form>
    </div>
</div>

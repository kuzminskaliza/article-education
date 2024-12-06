<?php

use backend\model\Category;

/** @var Category $category */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">
        <form action="/category/update?id=<?= $category->getId() ?>" method="post">
            <div class="form-group">
                <label for="inputName">Category Name</label>
                <input type="text"
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
                <input type="submit" value="Update" class="btn btn-success">
                <a href="/category/index" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

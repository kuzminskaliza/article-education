<?php
use backend\model\Article;

/* @var Article $article */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editing the article</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/article/index" class="btn btn-block btn-info">Back</a>
        </h3>

    </div>
    <div class="card-body">
        <form action="/article/update?id=<?= $article->getId() ?>" method="post">
            <div class="form-group">
                <label for="inputName">Title of the article</label>
                <input
                        type="text"
                        id="inputName"
                        class="form-control <?= $article->hasError('title') ? 'is-invalid' : 'is-valid'?>"
                        name="title"
                        value="<?= $article->getTitle() ?? ''?>">

                <?php if ($article->hasError('title')): ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('title') ?>
                    </div>
                <?php endif; ?>

            </div>
            <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus" class="form-control custom-select <?= $article->hasError('status') ? 'is-invalid' : '' ?>" name="status">
                    <option selected="" disabled="">Select one</option>
                    <option <?= $article->getStatus() == 'On Hold' ? 'selected' : '' ?>>In process</option>
                    <option <?= $article->getStatus() == 'Success' ? 'selected' : '' ?>>Done</option>
                </select>
                <?php if ($article->hasError('status')): ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('status') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea id="inputDescription" class="form-control <?= $article->hasError('description') ? 'is-invalid' : '' ?>" rows="4" name="description"><?= $article->getDescription() ?? '' ?></textarea>
                <?php if ($article->hasError('description')): ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('description') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" value="Edit" class="btn btn-success">
            </div>
        </form>
    </div>
</div>

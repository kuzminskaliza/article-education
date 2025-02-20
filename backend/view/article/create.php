<?php

use backend\model\Article;
use backend\model\Category;
use backend\model\ArticleTag;

/* @var Article $article */
/* @var Category $category */
/* @var ArticleTag $articleTag */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Creating an article</h1>
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
        <form action="/article/create" method="post">
            <div class="form-group">
                <label for="inputName">Title of the article</label>
                <input
                        type="text"
                        id="inputName"
                        class="form-control <?= $article->hasError('title') ? 'is-invalid' : 'is-valid' ?>"
                        name="title"
                        value="<?= $article->getTitle() ?? '' ?>">

                <?php if ($article->hasError('title')) : ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('title') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="inputStatus">Status</label>
                <select id="inputStatus"
                        class="form-control custom-select <?= $article->hasError('status_id') ? 'is-invalid' : 'is-valid' ?>"
                        name="status_id">
                    <option selected="" disabled="">Select one</option>
                    <?php foreach ($article->getArticleStatus()->findAll() as $articleStatus) : ?>
                        <option value="<?= $articleStatus->getId() ?>" <?= $article->getStatusId() === $articleStatus->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($articleStatus->getTitle()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($article->hasError('status_id')) : ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('status_id') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Categories</label>
                <div class="select2-purple">
                    <select name="category_ids[]"
                            class="select2 <?= $article->hasError('category_ids') ? 'is-invalid' : 'is-valid' ?>"
                            multiple=""
                            data-placeholder="Select categories"
                            data-dropdown-css-class="select2-purple"
                            style="width: 100%;">
                        <?php foreach ($category->findAll() as $category) : ?>
                            <option value="<?= $category->getId() ?>"
                                <?= in_array($category->getId(), $article->getCategoryIds()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($article->hasError('category_ids')) : ?>
                        <div class="invalid-feedback">
                            <?= $article->getError('category_ids') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label>Tags</label>
                <div id="tag-container">
                    <div class="input-group mb-3 tag-input">
                        <input type="text"
                               name="tags[0]"
                               class="form-control <?= $article->hasError('tags') ? 'is-invalid' : 'is-valid' ?>"
                               value="<?= $articleTag->getTag() ?? '' ?>">
                        <div class="input-group-append">
                            <span class="input-group-text remove-tag"><i class="fas fa-times"></i></span>
                        </div>
                    </div>
                </div>
                <?php if ($article->hasError('tags')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= $article->getError('tags') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button id="addTag" type="button" class="btn btn-info">Add tag</button>
            </div>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea id="inputDescription"
                          class="form-control <?= $article->hasError('description') ? 'is-invalid' : 'is-valid' ?>"
                          rows="4"
                          name="description"><?= htmlspecialchars($article->getDescription() ?? '') ?></textarea>
                <?php if ($article->hasError('description')) : ?>
                    <div class="invalid-feedback">
                        <?= $article->getError('description') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-success">
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="../../web/js/tags.js"></script>

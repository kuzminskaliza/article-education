<?php

use backend\model\Category;
use backend\model\search\ArticleSearch;

/** @var ArticleSearch $searchModel */
/** @var Category $category */
?>
<div id="filterSearch" class="collapse">
    <div>
        <form action="/article/index" method="get">
            <div class="form-group">
                <label for="ArticleSearchId">ID</label>
                <input type="text"
                       id="ArticleSearchId"
                       class="form-control <?= $searchModel->hasError('id') ? 'is-invalid' : 'is-valid' ?>"
                       name="ArticleSearch[id]"
                       value="<?= $searchModel->getId() ?? '' ?>">
                <?php if ($searchModel->hasError('id')) : ?>
                    <div class="invalid-feedback">
                        <?= $searchModel->getError('id') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="ArticleSearchIdTitle">Title of the article</label>
                <input type="text"
                       id="ArticleSearchIdTitle"
                       class="form-control <?= $searchModel->hasError('title') ? 'is-invalid' : 'is-valid' ?>"
                       name="ArticleSearch[title]"
                       value="<?= $searchModel->getTitle() ?? '' ?>">
                <?php if ($searchModel->hasError('title')) : ?>
                    <div class="invalid-feedback">
                        <?= $searchModel->getError('title') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="ArticleSearchCategoryName">Category Name</label>
                <input type="text"
                       id="ArticleSearchCategoryName"
                       class="form-control <?= $searchModel->hasError('category_name') ? 'is-invalid' : 'is-valid' ?>"
                       name="ArticleSearch[category_name]"
                       value="<?= $searchModel->getCategoryName() ?? '' ?>">
                <?php if ($searchModel->hasError('category_name')) : ?>
                    <div class="invalid-feedback">
                        <?= $searchModel->getError('category_name') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="ArticleSearchStatusIds">Statuses</label>
                <div class="select2-purple">
                    <select class="select2 <?= $searchModel->hasError('status_ids') ? 'is-invalid' : 'is-valid' ?>"
                            name="ArticleSearch[status_ids][]"
                            id="ArticleSearchStatusIds"
                            multiple=""
                            data-placeholder="Select status"
                            data-dropdown-css-class="select2-purple"
                            style="width: 100%;">
                        <?php foreach ($searchModel->getArticleStatus()->findAll() as $articleStatus) : ?>
                            <option value="<?= $articleStatus->getId() ?>" <?= $searchModel->getStatusId() === $articleStatus->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($articleStatus->getTitle()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($searchModel->hasError('status_ids')) : ?>
                        <div class="invalid-feedback">
                            <?= $searchModel->getError('status_ids') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="ArticleSearchCategoryIds">Categories</label>
                <div class="select2-purple">
                    <select name="ArticleSearch[category_ids][]"
                            class="select2 <?= $searchModel->hasError('category_ids') ? 'is-invalid' : 'is-valid' ?>"
                            multiple=""
                            id="ArticleSearchCategoryIds"
                            data-placeholder="Select categories"
                            data-dropdown-css-class="select2-purple"
                            style="width: 100%;">
                        <?php foreach ($category->findAll() as $category) : ?>
                            <option value="<?= $category->getId() ?>"
                                <?= in_array($category->getId(), $searchModel->getCategoryIds()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($searchModel->hasError('category_ids')) : ?>
                        <div class="invalid-feedback">
                            <?= $searchModel->getError('category_ids') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Search" class="btn btn-primary">
                <a class="btn btn-default" href="/article/index">Reset</a>
            </div>
        </form>
    </div>
</div>
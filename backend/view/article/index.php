<?php

use backend\model\Article;
use backend\model\search\ArticleSearch;

/** @var Article[] $articles */
/** @var ArticleSearch $searchModel */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of articles</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/article/create" class="btn btn-block btn-success">Add an article</a>
        </h3> &nbsp;

        <button class="btn btn-primary" type="button"
                data-toggle="collapse" data-target="#filterSearch"
                data-expanded="false" aria-controls="filterSearch">
            Filter
        </button>
        <div id="filterSearch" class="collapse">
            <div>
                <form action="/article/index" method="get">
                    <div class="form-group">
                        <label for="inputName">ID</label>
                        <input
                                type="text"
                                id="inputName"
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
                        <label for="inputName">Title of the article</label>
                        <input
                                type="text"
                                id="inputName"
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
                        <label for="inputStatus">Status</label>
                        <select id="inputStatus"
                                class="form-control custom-select <?= $searchModel->hasError('status_id') ? 'is-invalid' : 'is-valid' ?>"
                                name="ArticleSearch[status_id]">
                            <option selected="" disabled="">Select one</option>
                            <?php foreach ($searchModel->getArticleStatus()->findAll() as $articleStatus) : ?>
                                <option value="<?= $articleStatus->getId() ?>" <?= $searchModel->getStatusId() === $articleStatus->getId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($articleStatus->getTitle()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($searchModel->hasError('status_id')) : ?>
                            <div class="invalid-feedback">
                                <?= $searchModel->getError('status_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Search" class="btn btn-primary">
                        <a class="btn btn-default" href="/article/index">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
            <tr>
                <th style="width: 1%">Id</th>
                <th style="width: 20%">Title</th>
                <th style="width: 25%">Description</th>
                <th style="width: 15%">Status</th>
                <th style="width: 1%">Category</th>
                <th style="width: 8%" class="text-center"></th>

            </tr>
            </thead>

            <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td><?= $article->getId() ?></td>
                    <td><?= $article->getTitle() ?></td>
                    <td class="text-truncate modal-sm"><?= $article->getDescription() ?></td>
                    <td><?= $article->getArticleStatus()->getTitle() ?></td>
                    <td>
                        <?php foreach ($article->getCategories() as $articleCategory) : ?>
                            <?= htmlspecialchars($articleCategory->getCategory()->getName()) ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td class="project_progress"></td>
                    <td class="project-state"></td>

                    <td class="project-actions text-right">

                        <a class="btn btn-primary btn-sm"
                           href="/article/view?id=<?= $article->getId() ?>">
                            <i class="fas fa-folder"> </i>
                            <span>View</span></a>

                        <a class="btn btn-warning btn-sm"
                           href="/article/update?id=<?= $article->getId() ?>">
                            <i class="fas fa-pencil-alt"></i>
                            <span>Edit</span></a>

                        <form action="/article/delete?id=<?= $article->getId() ?>" method="POST"
                              class="d-xl-inline-block">
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete the article?')">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php

use backend\model\Article;

/** @var Article[] $articles */

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
        </h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
            <tr>
                <th style="width: 1%">Id</th>
                <th style="width: 20%">Title</th>
                <th style="width: 30%">Description</th>
                <th>Status</th>
                <th style="width: 8%" class="text-center"></th>

            </tr>
            </thead>

            <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article->getId() ?></td>
                    <td><?= $article->getTitle() ?></td>
                    <td><?= $article->getDescription() ?></td>
                    <td><?= $article->getStatus() ?></td>
                    <td class="project_progress"></td>
                    <td class="project-state"></td>

                    <td class="project-actions text-right">

                        <a class="btn btn-primary btn-sm" href="/article/view?id=<?= $article->getId() ?>"><i
                                    class="fas fa-folder"></i>Review</a>
                        <a class="btn btn-info btn-sm" href="/article/update?id=<?= $article->getId() ?>"><i
                                    class="fas fa-pencil-alt"></i>Edit</a>
                        <a class="btn btn-danger btn-sm" href="/article/delete?id=<?= $article->getId() ?>"><i
                                    class="fas fa-trash"></i>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>






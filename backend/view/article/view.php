<?php

use backend\model\Article;

/* @var Article $article */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View</h1>
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
        <table class="table table-bordered table-hover" style="border: none;">
            <tbody>
            <tr style="border: none;">
                <td style="border: none;"><strong>Id:</strong></td>
                <td style="border: none;"><?= $article->getId() ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Title of the article:</strong></td>
                <td style="border: none;"><?= $article->getTitle() ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Status:</strong></td>
                <td style="border: none;"><?= $article->getArticleStatus()->getTitle() ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Category:</strong></td>
                <td style="border: none;">
                    <?php foreach ($article->getCategories() as $articleCategory) : ?>
                        <?= htmlspecialchars($articleCategory->getCategory()->getName()) ?><br>
                    <?php endforeach; ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Description:</strong></td>
                <td style="border: none;"><?= $article->getDescription() ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<?php

use backend\model\Article;

/* @var Article $article */
?>


<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a href="/article/index" class="btn btn-block btn-info">Back</a>
            </h3>
        </div>
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
                <td style="border: none;"><?= $article->getStatus() ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Description:</strong></td>
                <td style="border: none;"><?= $article->getDescription() ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</section>

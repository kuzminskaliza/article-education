<?php

use backend\model\Category;

/** @var Category[] $categories */

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List of Categories</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/category/create" class="btn btn-block btn-success">Add a Category</a>
        </h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
            <tr>
                <th style="width: 10%">Id</th>
                <th style="width: 40%">Name</th>
                <th style="width: 10%" class="text-right"></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?= $category->getId() ?></td>
                    <td><?= $category->getName() ?></td>

                    <td class="project-actions text-right">
                        <a class="btn btn-warning btn-sm" href="/category/update?id=<?= $category->getId() ?>">
                            <i class="fas fa-pencil-alt"></i>
                            <span>Edit</span>
                        </a>
                        <form action="/category/delete?id=<?= $category->getId() ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
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

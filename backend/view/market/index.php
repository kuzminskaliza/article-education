<?php

use backend\model\Market;

/* @var Market[] $markets */

// кнопка створення продавця
// список у вигляді таблиці (кнопки перегляду редагування, видалення)

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Список продавців</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="/market/create" class="btn btn-block btn-success">Створити продавця</a>
        </h3>

    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Id</th>
                    <th style="width: 20%">title</th>
                    <th style="width: 30%">description</th>
                    <th>Status</th>
                    <th style="width: 8%" class="text-center">company</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($markets as $market):?>
                <tr>
                    <td><?= $market->getId()?></td>
                    <td><?= $market->getTitle()?></td>
                    <td><?= $market->getDescription()?></td>
                    <td><?= $market->getStatus()?></td>
                    <td><?= $market->getCompany()?></td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="/market/view?id=<?= $market->getId()?>">
                            <i class="fas fa-folder"></i>Перегляд
                        </a>
                        <a class="btn btn-info btn-sm" href="/market/update?id=<?= $market->getId()?>">
                            <i class="fas fa-pencil-alt"></i>Редагувати
                        </a>
                        <a class="btn btn-danger btn-sm" href="/market/delete?id=<?= $market->getId()?>">
                            <i class="fas fa-trash"></i>Видалити
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
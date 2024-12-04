<?php

/* @var string $message */
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>404 Error page</h1>
            </div>
        </div>
    </div>
</section>

<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>

    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

        <p>We could not find the page you were looking for.</p>
        <p><?= $message ?></p>

<a href="/article/index">return to List of Article</a>
    </div>

</div>

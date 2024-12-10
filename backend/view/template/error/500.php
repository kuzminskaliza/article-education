<?php

/* @var string $message */
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>500 Error Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">500 Error Page</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger">500</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

            <p><?= $message ?></p>
            <p>
                We will work on fixing that right away.
            </p>
            <a href="/article/index" class="btn btn-block btn-info">return to back</a>
        </div>
    </div>
</section>

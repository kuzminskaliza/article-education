<?php

namespace backend\controller;

use backend\model\GitHubApiClient;

class ApiController extends BaseController
{
    private GitHubApiClient $apiService;

    public function __construct()
    {
        $this->apiService = new GitHubApiClient();
    }

    public function actionIndex(): string
    {
        $apiData = $this->apiService->fetchData();
        return $this->render('index', [
            'apiData' => $apiData
        ]);
    }
}

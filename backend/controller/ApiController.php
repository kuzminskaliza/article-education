<?php

namespace backend\controller;

use backend\model\ApiService;

class ApiController extends BaseController
{
    private ApiService $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    public function actionIndex(): string
    {
        $apiData = $this->apiService->fetchData();
        return $this->render('index', [
            'apiData' => $apiData
        ]);
    }
}

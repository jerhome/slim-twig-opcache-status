<?php
require '../app/vendor/autoload.php';

$app = new \Slim\Slim([
    'debug' => true,
    'view' => new \Slim\Views\Twig(),
]);

$app->view()->parserOptions = [
    'debug' => true,
    'cache' => '../app/data/cache',
];

$app->get('/', function () use ($app) {
    require('../app/lib/OpCacheDataModel.php');
    $dataModel = new OpCacheDataModel();
    $data = [
        'PageTitle' => $dataModel->getPageTitle(),
        'StatusDataRows' => $dataModel->getStatusDataRows(),
        'ConfigDataRows' => $dataModel->getConfigDataRows(),
        'ScriptStatusCount' => $dataModel->getScriptStatusCount(),
        'ScriptStatusRows' => $dataModel->getScriptStatusRows(),
        'GraphDataSetJson' => $dataModel->getGraphDataSetJson(),
        'HumanUsedMemory' => $dataModel->getHumanUsedMemory(),
        'HumanFreeMemory' => $dataModel->getHumanFreeMemory(),
        'HumanWastedMemory' => $dataModel->getHumanWastedMemory(),
        'WastedMemoryPercentage' => $dataModel->getWastedMemoryPercentage(),
        'D3Scripts' => $dataModel->getD3Scripts(),
    ];
    $body = $app->view()->render('opcache.twig', ['data' => $data]);
    $app->response->body($body);
});

$app->run();

<?php
use Slim\App;
use Src\Controllers\TransacaoController;

return function (App $app) {
    $app->post('/transacao', [TransacaoController::class, 'store']);
    $app->get('/transacao/{id}', [TransacaoController::class, 'show']);
    $app->delete('/transacao', [TransacaoController::class, 'destroyAll']);
    $app->delete('/transacao/{id}', [TransacaoController::class, 'destroyId']);
    $app->get('/estatistica', [TransacaoController::class, 'statistic']);
};

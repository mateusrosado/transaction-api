<?php
use Slim\App;
use Src\Controllers\TransacaoController;

return function (App $app) {
    $app->post('/transacao', [TransacaoController::class, 'store']);
    $app->get('/transacao/{id}', [TransacaoController::class, 'show']);
};

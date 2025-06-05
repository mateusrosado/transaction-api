<?php
namespace Src\Controllers;

use DateTime;
use DateTimeZone;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\Models\Transacao;
use Src\Models\DAO\TransacaoDAO;
use Exception;

class TransacaoController {    
    public function store(Request $request, Response $response) {
        try {
            $dados = $request->getParsedBody();
            if (!is_array($dados)) {
                return $response->withStatus(400);
            }
            
            $transacao = new Transacao($dados['id'], $dados['valor'], $dados['dataHora']);

            if(!isset($transacao->id) || !isset($transacao->valor) || !isset($transacao->dataHora)) {
                return $response->withStatus(422);
            }
            $dao = new TransacaoDAO();

            if($dao->existeId($transacao->id)) {
                return $response->withStatus(422);
            }

            $sucesso = $dao->inserir($transacao);

            if ($sucesso) {
                return $response->withStatus(201);
            } else {
                return $response->withStatus(422);
            }
        } catch (Exception $e) {
            return $response->withStatus(400);
        }
    }

    public function show(Request $request, Response $response, $args) {
        try {
            if (!isset($args['id'])) {
                return $response->withStatus(404);
            }
            
            $dao = new TransacaoDAO();
            
            $transacao = $dao->buscarPorId($args['id']);

            if ($transacao) {
                $transacao['dataHora'] = new DateTime($transacao['dataHora'], new DateTimeZone('America/Sao_Paulo'));
                $transacao['dataHora'] = $transacao['dataHora']->format(DateTime::ATOM);
                $response->getBody()->write(json_encode($transacao));
                return $response->withStatus(200);
            } else {
                return $response->withStatus(404);
            }
        } catch (Exception $e) {
            return $response->withStatus(400);
        }
    }

    public function destroyAll(Request $request, Response $response) {
        try {            
            $dao = new TransacaoDAO();
            
            $sucesso = $dao->excluirTabela();

            if ($sucesso) {
                return $response->withStatus(200);
            } else {
                return $response->withStatus(404);
            }
        } catch (Exception $e) {
            return $response->withStatus(400);
        }
    }

    public function destroyId(Request $request, Response $response, $args) {
        try {
            if (!isset($args['id'])) {
                return $response->withStatus(404);
            }
            
            $dao = new TransacaoDAO();
            
            if(!$dao->existeId($args['id'])) {
                return $response->withStatus(404);
            }

            $sucesso = $dao->excluirId($args['id']);

            if ($sucesso) {
                return $response->withStatus(200);
            } else {
                return $response->withStatus(404);
            }
        } catch (Exception $e) {
            return $response->withStatus(400);
        }
    }

    public function statistic(Request $request, Response $response, $args) {
        try {
            $dao = new TransacaoDAO();
            
            $estatistica = $dao->gerarEstatisticas();

            if (is_array($estatistica)) {
                $response->getBody()->write(json_encode($estatistica));
                return $response->withStatus(200);
            } else {
                return $response->withStatus(400);
            }
        } catch (Exception $e) {
            return $response->withStatus(400);
        }
    }
}
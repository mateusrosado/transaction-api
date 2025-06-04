<?php
namespace Src\Controllers;

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
            
            $transacao = $dao->buscarTarefa($args['id']);

            if ($transacao) {
                $response->getBody()->write(json_encode($transacao));
                return $response->withStatus(200);
            } else {
                return $response->withStatus(404);
            }
        } catch (Exception $e) {
                return $response->withStatus(404);
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
                return $response->withStatus(404);
        }
    }
}
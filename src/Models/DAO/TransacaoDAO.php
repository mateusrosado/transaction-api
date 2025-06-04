<?php
namespace Src\Models\DAO;

use Src\Models\Transacao;
use Src\Config\Connection;
use PDO;
use PDOException;

class TransacaoDAO {
    private $db;

    public function __construct() {
        $this->db = Connection::getConn();
    }

    public function inserir(Transacao $transacao) {
        try{
            $stmt = $this->db->prepare("INSERT INTO transacoes (id, valor, dataHora) VALUES (?, ?, ?)");
            return $stmt->execute([$transacao->id, $transacao->valor, $transacao->dataHora]);
        } catch(PDOException $e) {
            return false;
        }
    }

    public function buscarId($id){
        try{
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM transacoes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn() > 0;
        } catch(PDOException $e) {
            return true;
        }
    }
}
<?php
namespace Src\Models;

use DateTime;
use Exception;

class Transacao {
    public $id;
    public $valor;
    public $dataHora;

    public function __construct($id = NULL, $valor = NULL, $dataHora = NULL) {
        if($this->validarID($id)) $this->id = $id;
        if($this->validarValor($valor)) $this->valor = $valor;
        if($this->validarData($dataHora)) $this->dataHora = $dataHora;
    }

    private function validarID($uuid) {
        if ($uuid === null) return false;
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid);
    }

    private function validarValor($valor) {
        if ($valor === null) return false;
        return is_numeric($valor) && floatval($valor) >= 0;
    }
    
    private function validarData($dataHora) {
        if ($dataHora === null) return false;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?(Z|[+-]\d{2}:\d{2})?$/', $dataHora)) {
            return false;
        }
        
        try {
            $dataObjeto = new DateTime($dataHora);
            $agora = new DateTime();
            return $dataObjeto <= $agora;
        } catch (Exception $e) { 
            return false;
        }
    }
}
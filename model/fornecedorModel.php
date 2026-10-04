<?php

class Fornecedor
{
    private $idFornecedor;
    private $nomeFornecedor;
    private $telefone;
    private $endereco;
    private $email;

    public function __construct($idFornecedor, $nomeFornecedor, $telefone, $endereco, $email)
    {
        $this->idFornecedor = $idFornecedor;
        $this->nomeFornecedor = $nomeFornecedor;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->email = $email;
    }

    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
        return $this;
    }

    public function getNomeFornecedor()
    {
        return $this->nomeFornecedor;
    }

    public function setNomeFornecedor($nomeFornecedor)
    {
        $this->nomeFornecedor = $nomeFornecedor;
        return $this;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
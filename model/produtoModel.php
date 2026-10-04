<?php
class Produto
{
    private $idproduto;
    private $nomeproduto;
    private $precoUnitario;
    private $dataValidade;
    private $dataConfecao;

    public function __construct($idproduto, $nomeproduto, $precoUnitario, $dataValidade, $dataConfecao)
    {
        $this->idproduto = $idproduto;
        $this->nomeproduto = $nomeproduto;
        $this->precoUnitario = $precoUnitario;
        $this->dataValidade = $dataValidade;
        $this->dataConfecao = $dataConfecao;
    }

    public function getIdproduto()
    {
        return $this->idproduto;
    }
    public function setIdproduto($idproduto)
    {
        $this->idproduto = $idproduto;
    }

    public function getProduto()
    {
        return $this->nomeproduto;
    }
    public function setProduto($nomeproduto)
    {
        $this->nomeproduto = $nomeproduto;
    }

    public function getPrecoUnitario()
    {
        return $this->precoUnitario;
    }
    public function setPrecoUnitario($precoUnitario)
    {
        $this->precoUnitario = $precoUnitario;
    }

    public function getDataValidade()
    {
        return $this->dataValidade;
    }
    public function setDataValidade($dataValidade)
    {
        $this->dataValidade = $dataValidade;
    }

    public function getDataConfecao()
    {
        return $this->dataConfecao;
    }
    public function setDataConfecao($dataConfecao)
    {
        $this->dataConfecao = $dataConfecao;
    }

    public function __toString()
    {
        return "Produto:{$this->nomeproduto} Preço:{$this->precoUnitario} Validade:{$this->dataValidade}<br>";
    }
}

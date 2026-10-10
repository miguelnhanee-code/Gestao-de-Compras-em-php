<?php
class Compra
{
    private $idcompra;
    private $quantidade;
    private $dataCompra;
    private $idproduto;
    private $idcliente;
    private $nomeProduto;
    private $precoProduto;
    private $nomeCliente;
    private $nomeCaixa;


    public function __construct($idcompra, $quantidade, $dataCompra, $idproduto, $idcliente, $nomeProduto = null, $precoProduto = null, $nomeCliente = null, $nomeCaixa = null)
    {
        $this->idcompra = $idcompra;
        $this->quantidade = $quantidade;
        $this->dataCompra = $dataCompra;
        $this->idproduto = $idproduto;
        $this->idcliente = $idcliente;
        $this->nomeProduto = $nomeProduto;
        $this->precoProduto = $precoProduto;
        $this->nomeCliente = $nomeCliente;
        $this->nomeCaixa = $nomeCaixa;
    }

    public function getIdcompra()
    {
        return $this->idcompra;
    }
    public function setIdcompra($idcompra)
    {
        $this->idcompra = $idcompra;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getDataCompra()
    {
        return $this->dataCompra;
    }
    public function setDataCompra($dataCompra)
    {
        $this->dataCompra = $dataCompra;
    }

    public function getIdproduto()
    {
        return $this->idproduto;
    }
    public function setIdproduto($idproduto)
    {
        $this->idproduto = $idproduto;
    }

    public function getIdcliente()
    {
        return $this->idcliente;
    }
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }

    public function getNomeProduto()
    {
        return $this->nomeProduto;
    }
    public function setNomeProduto($nomeProduto)
    {
        $this->nomeProduto = $nomeProduto;
    }

    public function getPrecoProduto()
    {
        return $this->precoProduto;
    }
    public function setPrecoProduto($precoProduto)
    {
        $this->precoProduto = $precoProduto;
    }

    public function getNomeCliente()
    {
        return $this->nomeCliente;
    }
    public function setNomeCliente($nomeCliente)
    {
        $this->nomeCliente = $nomeCliente;
    }

    public function getNomeCaixa()
    {
        return $this->nomeCaixa;
    }
    public function setNomeCaixa($nomeCaixa)
    {
        $this->nomeCaixa = $nomeCaixa;
    }

    public function __toString()
    {
        return "Compra:{$this->idcompra} Quantidade:{$this->quantidade} Data da Compra:{$this->dataCompra}<br>";
    }
}

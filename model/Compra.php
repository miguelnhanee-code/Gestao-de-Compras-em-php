<?php
class Compra
{
    private $idcompra;
    private $quantidade;
    private $dataCompra;
    private $idproduto;
    private $idcliente;
    // private $precoTotal;

    public function __construct($idcompra, $quantidade, $dataCompra, $idproduto, $idcliente)
    {
        $this->idcompra = $idcompra;
        $this->quantidade = $quantidade;
        $this->dataCompra = $dataCompra;
        $this->idproduto = $idproduto;
        $this->idcliente = $idcliente;
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

    public function __toString()
    {
        return "Compra:{$this->idcompra} Quantidade:{$this->quantidade} Data da Compra:{$this->dataCompra}<br>";
    }
}

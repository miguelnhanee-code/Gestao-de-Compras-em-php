<?php
class Produto
{
    private $idproduto;
    private $nomeproduto;
    private $precounitario;
    private $datavalidade;
    private $dataconfecao;

    public function __construct($idproduto, $nomeproduto, $precoUnitario, $dataValidade, $dataConfecao)
    {
        $this->idproduto = $idproduto;
        $this->nomeproduto = $nomeproduto;
        $this->precounitario = $precoUnitario;
        $this->datavalidade = $dataValidade;
        $this->dataconfecao = $dataConfecao;
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
        return $this->precounitario;
    }
    public function setPrecoUnitario($precoUnitario)
    {
        $this->precounitario = $precoUnitario;
    }

    public function getDataValidade()
    {
        return $this->datavalidade;
    }
    public function setDataValidade($datavalidade)
    {
        $this->datavalidade = $datavalidade;
    }

    public function getDataConfecao()
    {
        return $this->dataconfecao;
    }
    public function setDataConfecao($dataconfecao)
    {
        $this->dataconfecao = $dataconfecao;
    }

    public function __toString()
    {
        return "Produto:{$this->nomeproduto} Preco:{$this->precounitario}  Validade:{$this->datavalidade} 
        Confeccao:{$this->dataconfecao}<br>";
    }
}

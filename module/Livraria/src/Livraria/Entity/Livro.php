<?php

namespace Livraria\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="livros")
* @ORM\Entity(repositoryClass="Livraria\Entity\LivroRepository")
*/
class Livro
{

    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    * @var int
    */
    private $id;

    /**
    * @ORM\Column(type="text")
    * @var string
    */
    private $nome;

    /**
    * @ORM\ManyToOne(targetEntity="Livraria\Entity\Categoria", inversedBy="livro")
    * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
    */
    private $categoria;

    /**
    * @ORM\Column(type="text")
    * @var string
    */
    private $autor;

    /**
    * @ORM\Column(type="text")
    * @var string
    */
    private $isbn;

    /**
    * @ORM\Column(type="float")
    * @var float
    */
    private $valor;

    public function __construct($options = null)
    {
        Configurator::configure($this, $options);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        return $this->nome = $nome;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        return $this->categoria = $categoria;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor)
    {
        return $this->autor = $autor;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        return $this->isbn = $isbn;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        return $this->valor = $valor;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'autor' => $this->getAutor(),
            'isbn' => $this->getIsbn(),
            'valor' => $this->getValor(),
            'categoria' => $this->getCategoria()->getId()
        );
    }
}
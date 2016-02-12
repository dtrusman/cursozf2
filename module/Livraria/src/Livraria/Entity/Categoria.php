<?php

    namespace Livraria\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;

    /**
    * @ORM\Entity
    * @ORM\Table(name="categorias")
    * @ORM\Entity(repositoryClass="Livraria\Entity\CategoriaRepository")
    */
    class Categoria
    {
        public function __construct($options = null)
        {
            Configurator::configure($this, $options);
            $this->livros = new ArrayCollection();
        }

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
        * @ORM\OneToMany(targetEntity="Livraria\Entity\Livro", mappedBy="categoria")
        */
        private $livros;

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

        public function getLivros()
        {
            return $this->livros;
        }

        public function __toString()
        {
            return $this->nome;
        }

        public function toArray()
        {
            return array('id' => $this->getId(), 'nome' => $this->getNome());
        }
    }
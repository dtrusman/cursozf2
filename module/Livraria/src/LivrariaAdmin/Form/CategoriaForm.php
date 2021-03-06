<?php

    namespace LivrariaAdmin\Form;

    use Zend\Form\Form;

    class CategoriaForm extends Form
    {

        function __construct($name = null)
        {
            parent::__construct('categoria');

            $this->setAttribute('method', 'post');
            $this->setInputFilter(new CategoriaFilter);

            $this->add(array(
                'name' => 'id',
                'attributes' => array(
                    'type' => 'hidden'
                )
            ));

            $this->add(array(
                'name' => 'nome',
                'options' => array(
                    'type' => 'text'
                ),
                'attributes' => array(
                    'id' => 'nome',
                    'placeholder' => 'Entre com o nome',
                    'class' => 'form-control'
                )
            ));

            $this->add(array(
                'name' => 'submit',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Salvar',
                    'class' => 'btn btn-primary'
                )
            ));
        }
    }
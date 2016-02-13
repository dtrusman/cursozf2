<?php

    namespace LivrariaAdmin\Form;

    use Zend\Form\Form;

    class UserForm extends Form
    {

        function __construct($name = null)
        {
            parent::__construct('user');

            $this->setAttribute('method', 'post');

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
                'name' => 'email',
                'options' => array(
                    'type' => 'email'
                ),
                'attributes' => array(
                    'id' => 'email',
                    'placeholder' => 'Entre com o email',
                    'class' => 'form-control'
                )
            ));

            $this->add(array(
                'name' => 'password',
                'options' => array(
                    'type' => 'password'
                ),
                'attributes' => array(
                    'type' => 'password',
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
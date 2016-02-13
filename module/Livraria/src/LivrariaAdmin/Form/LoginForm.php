<?php

    namespace LivrariaAdmin\Form;

    use Zend\Form\Form;

    class LoginForm extends Form
    {

        function __construct($name = null)
        {
            parent::__construct('login');

            $this->setAttribute('method', 'post');

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
                    'value' => 'Login',
                    'class' => 'btn btn-primary'
                )
            ));
        }
    }
<?php

namespace Livraria\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $categoriaService = $this->getServiceLocator()->get('Livraria\Model\CategoriaService');
        $categorias = $categoriaService->fetchAll();

        return new ViewModel(array('categorias' => $categorias));
    }
}

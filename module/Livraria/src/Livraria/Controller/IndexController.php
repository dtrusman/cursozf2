<?php

namespace Livraria\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        // ZendDB
        /*$categoriaService = $this->getServiceLocator()->get('Livraria\Model\CategoriaService');
        $categorias = $categoriaService->fetchAll();*/

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository('Livraria\Entity\Categoria');

        $categorias = $repository->findAll();

        return new ViewModel(array('categorias' => $categorias));
    }
}

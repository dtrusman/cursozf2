<?php

    namespace LivrariaAdmin\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Zend\Paginator\Paginator,
        Zend\Paginator\Adapter\ArrayAdapter;
    use LivrariaAdmin\Form\CategoriaForm as FrmCategoria;

    class CategoriasController extends AbstractActionController
    {

        protected $em;

        /**
        * @var EntityManager
        */
        public function indexAction()
        {
            $list = $this->getEm()
                         ->getRepository('Livraria\Entity\Categoria')
                         ->findAll();

            $page = $this->params()->fromRoute('page');

            $paginator = new Paginator(new ArrayAdapter($list));
            $paginator->setCurrentPageNumber($page);
            $paginator->setDefaultItemCountPerPage(2);

            return new ViewModel(array('data' => $paginator, 'page' => $page));
        }

        public function newAction()
        {
            $form = new FrmCategoria();

            if($this->request->isPost())
            {
                $form->setData($this->request->getPost());
                if($form->isValid()) {
                    // rotina de inserir
                    $service = $this->getServiceLocator()->get('Livraria\Service\Categoria');
                    $service->insert($this->request->getPost()->toArray());

                    return $this->redirect()->toRoute('livraria-admin', array('controller' => 'categorias'));
                }
            }

            return new ViewModel(array('form' => $form));
        }

        public function editAction()
        {
            $form = new FrmCategoria();
            $request = $this->getRequest();

            $repository = $this->getEm()->getRepository('Livraria\Entity\Categoria');
            $entity = $repository->find($this->params()->fromRoute('id', 0));

            if($this->params()->fromRoute('id', 0)) {
                $form->setData($entity->toArray());
            }

            if($request->isPost()) {
                $form->setData($request->getPost());
                if($form->isValid()) {
                    $service = $this->getServiceLocator()->get('Livraria\Service\Categoria');
                    $service->update($this->request->getPost()->toArray());

                    return $this->redirect()->toRoute('livraria-admin-interna', array('controller' => 'categorias'));
                }
            }

            return new ViewModel(array('form' => $form));
        }

        public function deleteAction()
        {
            $service = $this->getServiceLocator()->get('Livraria\Service\Categoria');
            if($service->delete($this->params()->fromRoute('id', 0)))
                return $this->redirect()->toRoute('livraria-admin', array('controller' => 'categorias'));
        }

        /**
        * @return EntityManager
        */
        protected function getEm()
        {
            if(null === $this->em)
                $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

            return $this->em;
        }

    }
<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Livraria;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Livraria\Model\CategoriaTable;
use Livraria\Service\Categoria as CategoriaService;
use Livraria\Service\Livro as LivroService;
use LivrariaAdmin\Form\LivroForm as LivroFrm;
use Livraria\Service\User as UserService;
use Livraria\Auth\Adapter as AuthAdapter;

class Module
{
    public function onBootstrap($e)
    {
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 98);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ . 'Admin' => __DIR__ . '/src/' . __NAMESPACE__ . 'Admin',
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController", "dispatch", function($e) {
            $auth = new AuthenticationService;
            $auth->setStorage(new SessionStorage("LivrariaAdmin"));

            $controller = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();

            if(!$auth->hasIdentity() and ($matchedRoute == "livraria-admin" or $matchedRoute == "livraria-admin-interna")) {
                return $controller->redirect()->toRoute("livraria-admin-auth");
            }

        }, 99);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(

                'Livraria\Model\CategoriaService' => function($service) {
                    $dbAdapter = $service->get('Zend\Db\Adapter\Adapter');
                    $categoriaTable = new CategoriaTable($dbAdapter);
                    $categoriaService = new Model\CategoriaService($categoriaTable);

                    return $categoriaService;
                },

                'Livraria\Service\Categoria' => function($service) {
                    return new CategoriaService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Livraria\Service\Livro' => function($service) {
                    return new LivroService($service->get('Doctrine\ORM\EntityManager'));
                },
                'LivrariaAdmin\Form\LivroForm' => function($service) {
                    $em = $service->get('Doctrine\ORM\EntityManager');
                    $repository = $em->getRepository('Livraria\Entity\Categoria');
                    $categorias = $repository->fetchPairs();
                    return new LivroFrm(null, $categorias);
                },
                'Livraria\Service\User' => function($service) {
                    return new UserService($service->get('Doctrine\ORM\EntityManager'));
                },
                'Livraria\Auth\Adapter' => function($service) {
                    return new AuthAdapter($service->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'UserIdentity' => 'Livraria\View\Helper\UserIdentity'
            )
        );
    }
}

<?php

namespace Students;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
  public function getConfig()
  {
    return include __DIR__ . '/../config/module.config.php';
  }

  public function getServiceConfig()
  {
    return [
      'factories' =>
      [
        Model\StudentsTable::class => function($container)
        {
          $tableGateway = $container->get(Model\StudentsTableGateway::class);
          return new Model\StudentsTable($tableGateway);
        },
        Model\StudentsTableGateway::class => function ($container)
        {
          $dbAdapter = $container->get(AdapterInterface::class);
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Model\Students());
          return new TableGateway('students', $dbAdapter, null, $resultSetPrototype);
        },
        Model\ClassesTable::class => function($container)
        {
          $tableGateway = $container->get(Model\ClassesTableGateway::class);
          return new Model\ClassesTable($tableGateway);
        },
        Model\ClassesTableGateway::class => function ($container)
        {
          $dbAdapter = $container->get(AdapterInterface::class);
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Model\Classes());
          return new TableGateway('classes', $dbAdapter, null, $resultSetPrototype);
          },
      ],
    ];
  }

  public function getControllerConfig()
  {
    return [
      'factories' => [
        Controller\StudentsController::class => function($container)
        {
          return new Controller\StudentsController(
            $container->get(Model\StudentsTable::class),
            $container->get(Model\ClassesTable::class)
          );
        },
      ],
    ];
  }
}

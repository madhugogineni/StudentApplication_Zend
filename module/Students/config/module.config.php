<?php
namespace Students;

use Zend\Router\Http\Segment;
return [
  'router' => [
        'routes' => [
            'students' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/students[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\StudentsController::class,
                        'action'     => 'main',
                    ],
                ],
            ],
            'home' => [
              'type' => \Zend\Router\Http\Literal::class,
              'options' => [
                'route'    => '/',
                'defaults' => [
                  'controller' => Controller\StudentsController::class,
                  'action'     => 'main',
                ],
              ],
            ],
        ],
    ],

  'view_manager' =>[
    'template_path_stack'=>[
      'students'=> __DIR__ . '/../view',
    ],
    'strategies' => array('ViewJsonStrategy',),
  ],
];

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(

            'vf_js' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/vf/js',
                    'defaults' => array(
                        'controller' => 'VehicleFitsMetator\Controller\Js',
                        'action'     => 'index',
                    ),
                ),
            ),

            'vf_process' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/vf/process',
                    'defaults' => array(
                        'controller' => 'VehicleFitsMetator\Controller\Js',
                        'action'     => 'process',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'VehicleFitsMetator\Controller\Js' => 'VehicleFitsMetator\Controller\JsController',
        ),
    ),
);

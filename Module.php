<?php
/**
 * Metator (http://metator.com/)
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace VehicleFitsMetator;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\ProductMapper;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface
{
    protected $categoryMapper;

    function init($moduleManager)
    {

    }

    public function onBootstrap(MvcEvent $e)
    {

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
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(

            ),
        );
    }

    /**
     * Define Console Help text
     *
     * @param  Console $console
     * @return String
     */
    public function getConsoleUsage(Console $console)
    {
        return array(

        );
    }

    /**
     * Generates the Console Banner text
     *
     * @param  Console $console
     * @return String
     */
    public function getConsoleBanner(Console $console)
    {

    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables'=>array(
                'vfsearch'=>'\VehicleFitsMetator\View\Helper\Search',
            )
        );
    }
}
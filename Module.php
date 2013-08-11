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
        if(!isset($_SESSION)) {
            session_start();
        }
        define( 'ELITE_CONFIG_DEFAULT', dirname(__FILE__).'/config.default.ini' );
        define( 'ELITE_CONFIG', dirname(__FILE__).'/config.ini' );
        define( 'ELITE_PATH', '' );

        /** @var $zf2DB  \Zend\Db\Adapter\Adapter */
        $zf2DB =  $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        $pdo = $zf2DB->getDriver()->getConnection()->getResource();

        $zf1DB = $this->createDB($pdo);

        \VF_Singleton::getInstance()->setReadAdapter($zf1DB);
        \VF_Singleton::getInstance()->setRequest(new \Zend_Controller_Request_Http());
        \VF_Singleton::getInstance()->setProcessURL('/vf/process?');


        $search = new \VF_FlexibleSearch(new \VF_Schema, new \Zend_Controller_Request_Http);
        //$search->setConfig(new \Zend_Config(array()));
        $search->storeFitInSession();
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
                'Product\DataMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new DataMapper($dbAdapter);
                }
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

    function createDB($pdo)
    {
        $this->requireConfig();

        // ZF1 throws an exception if params aren't passed to constructor, but we never let it create a PDO
        // anyways because we inject our own PDO.
        $dbAdapter = new custom(array('dbname'=>'ignored', 'username'=>'ignored', 'password'=>'ignored'));
        $dbAdapter->setPDO($pdo);

        $dbAdapter->getConnection()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        $dbAdapter->getConnection()->query('SET character set utf8;');
        $dbAdapter->getConnection()->query('SET character_set_client = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_results = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_connection = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_database = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_server = utf8;');

        return $dbAdapter;
    }

    /* Figure out where we are reading the database configuration from */
    function requireConfig()
    {
        if(file_exists('config.php')) {
            require_once(__DIR__.'/vfconfig.php');
        } else {
            require_once(__DIR__.'/vfconfig.default.php');
        }
    }
}

class custom extends \Zend_Db_Adapter_Pdo_Mysql
{

    function setPDO($pdo)
    {
        $this->_connection = $pdo;
    }
}
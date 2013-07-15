<?php
/**
 * Metator (http://metator.com/)
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace VehicleFitsMetator\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\ServiceManager\ServiceLocatorAwareInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

class Search extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    function __invoke()
    {
        define( 'ELITE_CONFIG_DEFAULT', dirname(__FILE__).'/config.default.ini' );
        define( 'ELITE_CONFIG', dirname(__FILE__).'/config.ini' );

        \VF_Singleton::getInstance()->setReadAdapter($this->createDB());
        \VF_Singleton::getInstance()->setRequest(new \Zend_Controller_Request_Http());
        $search = new \VF_FlexibleSearch(new \VF_Schema, new \Zend_Controller_Request_Http);
        //$search->setConfig(new \Zend_Config(array()));
        $search->storeFitInSession();

        ob_start();
        include('search.phtml');
        $content = ob_get_clean();
        return $content;
    }
    
    function createDB()
    {
        $dbAdapter = new \Zend_Db_Adapter_Pdo_Mysql(array(
            'dbname' => 'magento',
            'username' => 'root',
            'password' => ''
        ));
        $dbAdapter->getConnection()->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        $dbAdapter->getConnection()->query('SET character set utf8;');
        $dbAdapter->getConnection()->query('SET character_set_client = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_results = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_connection = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_database = utf8;');
        $dbAdapter->getConnection()->query('SET character_set_server = utf8;');

        return $dbAdapter;
    }
}
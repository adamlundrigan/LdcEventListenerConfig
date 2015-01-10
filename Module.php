<?php
/**
 * LdcEventListenerConfig
 *
 * @link      http://github.com/adamlundrigan/LdcUserExtend for the canonical source repository
 * @copyright Copyright (c) 2014 Adam Lundrigan & Contributors
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace LdcEventListenerConfig;

class Module
{
    public function onBootstrap($e)
    {
        // Inject those delegator factories 
        $sm = $e->getApplication()->getServiceManager();        
        $injector = new ServiceManagerDelegatorFactoryInjector($sm->get('ldc-event-listener-config'));
        $injector->configure($sm);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return [
            'invokables' => [
                // Factory responsible for attaching the required delegator factories to inject the listeners
                'ldc-event-listener-delegator-factory' => 'LdcEventListenerConfig\ServiceManagerDelegatorFactory',
            ],
            'factories' => [
                // Factory responsible for loading the event listener attachments from config
                'ldc-event-listener-config' => 'LdcEventListenerConfig\ConfigurationFactory',
            ],
        ];
    }
}

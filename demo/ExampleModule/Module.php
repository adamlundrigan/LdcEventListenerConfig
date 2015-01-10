<?php
/**
 * LdcEventListenerConfig
 *
 * @link      http://github.com/adamlundrigan/LdcEventListenerConfig for the canonical source repository
 * @copyright Copyright (c) 2014 Adam Lundrigan & Contributors
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ExampleModule;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        // For this simple test we'll just trigger it from onBootstrap, 
        // but this could be run from anywhere in the system
        $service = $e->getApplication()->getServiceManager()->get('my_event_emitter');
        $service->emitTheEvent();
    }
    
    public function getAutoloaderConfig()
    {
        return array(
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
                'my_event_emitter' => 'ExampleModule\EventEmittingClass',
                'custom_event_listener' => 'ExampleModule\CustomEventListener',
            ],
        ];
    }

    public function getConfig()
    {
        return [
            'ldc-event-listener-config' => [
                'my_event_emitter' => [
                    'custom_event_listener' => -9999,
                ],
            ],
        ];
    }
}

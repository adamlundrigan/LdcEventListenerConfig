<?php
namespace LdcEventListenerConfig;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigurationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if ( !isset($config['ldc-event-listener-config']) || !is_array($config['ldc-event-listener-config']) ) {
            return [];
        }
        return $config['ldc-event-listener-config'];
    }
}

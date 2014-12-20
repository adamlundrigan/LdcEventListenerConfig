<?php
namespace LdcEventListenerConfig;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManagerDelegatorFactory implements DelegatorFactoryInterface
{
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        // We only want to operate on EventManager-aware objects
        $parent = $callback();
        if ( ! $parent instanceof EventManagerAwareInterface ) {
            return $parent;
        }

        // Bail out early if there are no listeners to attach
        $config = $serviceLocator->get('ldc-event-listener-config');
        if (empty($config) || !isset($config[$requestedName]) || empty($config[$requestedName])) {
            return $parent;
        }

        // Also bail out early if there is no event manager attached
        $eventManager = $parent->getEventManager();
        if ( ! $eventManager instanceof EventManagerInterface ) {
            return $parent;
        }

        // Loop over the configured service listeners and attach
        foreach ( $config[$requestedName] as $key => $value ) {
            $listenerName = is_numeric($key) ? $value : $key;
            $listenerPriority = is_numeric($key) ? 1 : $value;

            if ( ! $serviceLocator->has($listenerName) ) {
                throw new ServiceNotFoundException($listenerName);
            }
            $eventManager->attachAggregate(
                $serviceLocator->get($listenerName),
                $listenerPriority
            );
        }

        return $parent;
    }
}

<?php
namespace LdcEventListenerConfig;

use Zend\ServiceManager\ServiceManager;

class ServiceManagerDelegatorFactoryInjector
{
    /**
     * ServiceManager keys to inject delegator factory onto
     *
     * @var array
     */
    protected $mappings;

    /**
     * ServiceManager key containing the delegator factory to inject
     *
     * @var string
     */
    protected $delegatorFactoryName = 'ldc-event-listener-delegator-factory';

    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * Injects a delegator factory onto each specified ServiceManager key
     *
     * @param ServiceManager $sm
     * @return void
     */
    public function configure(ServiceManager $sm)
    {
        foreach ( $this->mappings as $serviceKey => $listeners ) {
            if ( ! $sm->has($serviceKey) ) {
                continue;
            }
            if ( $serviceKey === $this->delegatorFactoryName ) {
                continue;
            }
            $sm->addDelegator($serviceKey, $this->delegatorFactoryName);
        }
    }
}

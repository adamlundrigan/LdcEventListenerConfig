<?php
namespace LdcEventListenerConfigTest;

use LdcEventListenerConfig\ServiceManagerDelegatorFactoryInjector;

class ServiceManagerDelegatorFactoryInjectorTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldApplyDelegatorToMappedService()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('has')->with('testtest')->once()->andReturn(true);
        $sm->shouldReceive('addDelegator')->once()->withArgs([
            'testtest',
            'ldc-event-listener-delegator-factory',
        ]);

        $sut = new ServiceManagerDelegatorFactoryInjector([
            'testtest' => [],
        ]);
        $sut->configure($sm);
    }

    public function testItWouldBePointlessToAttachTheDelegatorToItself()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('has')->with('ldc-event-listener-delegator-factory')->once()->andReturn(true);
        $sm->shouldReceive('addDelegator')->never();

        $sut = new ServiceManagerDelegatorFactoryInjector([
            'ldc-event-listener-delegator-factory' => [],
        ]);
        $sut->configure($sm);
    }

    public function testSkipsAnyBlocksReferencingANonexistentService()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('has')->with('ldc-event-listener-delegator-factory')->once()->andReturn(false);
        $sm->shouldReceive('addDelegator')->never();

        $sut = new ServiceManagerDelegatorFactoryInjector([
            'ldc-event-listener-delegator-factory' => [],
        ]);
        $sut->configure($sm);
    }
}

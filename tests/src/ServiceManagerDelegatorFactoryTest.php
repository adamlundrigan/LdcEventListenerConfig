<?php
namespace LdcEventListenerConfigTest;

use LdcEventListenerConfig\ServiceManagerDelegatorFactory;

class ServiceManagerDelegatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testHappyCase()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('ldc-event-listener-config')->andReturn([
            'testtest' => [
                'my-fake-listener-one',
                'my-fake-listener-two' => 10,
            ],
            'notregistered' => [
                'not-a-listener' => 9999,
            ],
        ]);

        $fakeListenerOne = \Mockery::mock('Zend\EventManager\ListenerAggregateInterface');
        $sm->shouldReceive('get')->with('my-fake-listener-one')->andReturn($fakeListenerOne);
        $sm->shouldReceive('has')->with('my-fake-listener-one')->andReturn(true);

        $fakeListenerTwo = \Mockery::mock('Zend\EventManager\ListenerAggregateInterface');
        $sm->shouldReceive('get')->with('my-fake-listener-two')->andReturn($fakeListenerTwo);
        $sm->shouldReceive('has')->with('my-fake-listener-two')->andReturn(true);

        $sm->shouldReceive('get')->with('not-a-listener')->never();

        $name = 'testtest';
        $mock = \Mockery::mock('Zend\EventManager\EventManagerAwareInterface');
        $callback = function () use (&$mock, $fakeListenerOne, $fakeListenerTwo) {
            $em = \Mockery::mock('Zend\EventManager\EventManager')->makePartial();
            $em->shouldReceive('attachAggregate')->withArgs([$fakeListenerOne, 1])->once();
            $em->shouldReceive('attachAggregate')->withArgs([$fakeListenerTwo, 10])->once();
            $em->shouldReceive('attachAggregate')->withArgs([\Mockery::any(), 9999])->never();

            $mock->shouldReceive('getEventManager')->andReturn($em);
            return $mock;
        };

        $sut = new ServiceManagerDelegatorFactory();
        $this->assertSame($mock, $sut->createDelegatorWithName($sm, $name, $name, $callback));
    }

    public function testDelegatorFactoryShortCircuitsIfObjectIsNotEventManagerAware()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('ldc-event-listener-config')->never();

        $name = 'testtest';
        $object = new \stdClass();
        $callback = function () use ($object) { return $object; };

        $sut = new ServiceManagerDelegatorFactory();
        $this->assertSame($object, $sut->createDelegatorWithName($sm, $name, $name, $callback));
    }

    public function testDelegatorFactoryShortCircuitsIfConfigurationIsEmpty()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('ldc-event-listener-config')->andReturn([]);

        $name = 'testtest';
        $mock = \Mockery::mock('Zend\EventManager\EventManagerAwareInterface');
        $callback = function () use (&$mock) { return $mock; };

        $sut = new ServiceManagerDelegatorFactory();
        $this->assertSame($mock, $sut->createDelegatorWithName($sm, $name, $name, $callback));
    }

    public function testDelegatorFactoryShortCircuitsIfObjectDoesNotHaveAnEventManagerInstance()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('ldc-event-listener-config')->andReturn([
            'testtest' => [
                'my-fake-listener-one',
            ],
        ]);

        $name = 'testtest';
        $mock = \Mockery::mock('Zend\EventManager\EventManagerAwareInterface');
        $callback = function () use (&$mock) {
            $mock->shouldReceive('getEventManager')->andReturn(null);
            return $mock;
        };

        $sut = new ServiceManagerDelegatorFactory();
        $this->assertSame($mock, $sut->createDelegatorWithName($sm, $name, $name, $callback));
    }

    public function testDelegatorFactoryThrowsExceptionOnNonExistentListeners()
    {
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotFoundException');

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('ldc-event-listener-config')->andReturn([
            'testtest' => [
                'my-fake-listener-one',
            ],
        ]);
        $sm->shouldReceive('has')->with('my-fake-listener-one')->once()->andReturn(false);

        $name = 'testtest';
        $mock = \Mockery::mock('Zend\EventManager\EventManagerAwareInterface');
        $callback = function () use (&$mock) {
            $em = \Mockery::mock('Zend\EventManager\EventManager')->makePartial();

            $mock->shouldReceive('getEventManager')->andReturn($em);
            return $mock;
        };

        $sut = new ServiceManagerDelegatorFactory();
        $this->assertSame($mock, $sut->createDelegatorWithName($sm, $name, $name, $callback));
    }
}

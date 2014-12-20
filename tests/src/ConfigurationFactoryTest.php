<?php
namespace LdcEventListenerConfigTest;

use LdcEventListenerConfig\ConfigurationFactory;

class ConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testHappyCase()
    {
        $config = [
            'testtest' => [
                'my-fake-listener-one',
            ],
        ];
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('Config')->andReturn(['ldc-event-listener-config' => $config]);

        $sut = new ConfigurationFactory();
        $this->assertSame($config, $sut->createService($sm));
    }

    public function testNoConfigurationSpecified()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('Config')->andReturn([]);

        $sut = new ConfigurationFactory();
        $this->assertEmpty($sut->createService($sm));
    }

    public function testInvalidConfigurationSpecfieid()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $sm->shouldReceive('get')->with('Config')->andReturn(['ldc-event-listener-config' => 'not-an-array']);

        $sut = new ConfigurationFactory();
        $this->assertEmpty($sut->createService($sm));
    }
}

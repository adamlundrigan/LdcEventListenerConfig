<?php
namespace LdcEventListenerConfigTest;

use Zend\Mvc\Application;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Zend\EventManager\StaticEventManager::resetInstance();
    }

    public function testIntegration()
    {
        $configuration = [
            'modules'                 => [ 'LdcEventListenerConfig' ],
            'module_listener_options' => [
                'module_paths' => [
                    __DIR__ . '/..',
                ],
            ],
            'service_manager' => [
                'factories' => [
                    'my-dummy-object' => function ($sm) {
                        // Ensure that the delegator factory actually attaches the event we've asked it to
                        $em = \Mockery::mock('Zend\EventManager\EventManager');
                        $em->shouldReceive('setSharedManager');
                        $em->shouldReceive('attachAggregate')->once()->withArgs([
                            $sm->get('my-dummy-listener'),
                            -9999,
                        ]);

                        $obj = \Mockery::mock('Zend\EventManager\EventManagerAwareInterface');
                        $obj->shouldReceive('setEventManager');
                        $obj->shouldReceive('getEventManager')->andReturn($em);
                        return $obj;
                    },
                    'my-dummy-listener' => function ($sm) {
                        $obj = \Mockery::mock('Zend\EventManager\ListenerAggregateInterface');
                        return $obj;
                    },
                ],
            ],
        ];

        $serviceManager = new ServiceManager(new ServiceManagerConfig($configuration['service_manager']));
        $serviceManager->setService('ApplicationConfig', $configuration);
        $serviceManager->get('ModuleManager')->loadModules();

        $appConfig = $serviceManager->get('Config');
        $appConfig['ldc-event-listener-config'] = [
            'my-dummy-object' => [
                'my-dummy-listener' => -9999,
            ],
        ];
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Config', $appConfig);

        $application = $serviceManager->get('Application');
        $application->bootstrap();

        $sut = $application->getServiceManager()->get('my-dummy-object');
        $this->assertInstanceOf('Zend\EventManager\EventManagerAwareInterface', $sut);
    }
}

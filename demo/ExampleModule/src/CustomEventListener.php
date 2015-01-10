<?php
/**
 * LdcEventListenerConfig
 *
 * @link      http://github.com/adamlundrigan/LdcEventListenerConfig for the canonical source repository
 * @copyright Copyright (c) 2014 Adam Lundrigan & Contributors
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ExampleModule;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventManagerInterface;

class CustomEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1) 
    {
        $events->attach('the_event', [$this, 'handleTheEvent'], $priority);
    }
    
    public function handleTheEvent()
    {
        // For this simple test we'll just dump something to output
        var_dump('Hey there, sunshine!');
    }
}
<?php
/**
 * LdcEventListenerConfig
 *
 * @link      http://github.com/adamlundrigan/LdcEventListenerConfig for the canonical source repository
 * @copyright Copyright (c) 2014 Adam Lundrigan & Contributors
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ExampleModule;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class EventEmittingClass implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    
    public function emitTheEvent()
    {
        $this->getEventManager()->trigger('the_event', $this);
    }
}
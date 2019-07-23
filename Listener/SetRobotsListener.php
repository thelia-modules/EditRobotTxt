<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 22/07/2019
 * Time: 11:15
 */

namespace EditRobotTxt\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Form\Lang\LangUrlEvent;

class SetRobotsListener implements EventSubscriberInterface
{

    public function setRobotsTxt(LangUrlEvent $event){
        die(var_dump($event->getUrl()));
    }

    public static function getSubscribedEvents()
    {
        return array(
          TheliaEvents::LANG_URL => array("setRobotsTxt", 128)
        );
    }

}
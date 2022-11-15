<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 19/07/2019
 * Time: 11:45
 */

namespace EditRobotTxt\Hook;


use EditRobotTxt\Model\RobotsQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class ConfigurationHook extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event){
        $config = [];

        $robots = RobotsQuery::create()->find();
        $index = 1;
        foreach ($robots as $robot){
            $config[$index][0] = $robot->getDomainName();
            $config[$index][1] = $robot->getRobotsContent();
            $index += 1;
        }
        $event->add($this->render("module_configuration.html",
            ['config' => $config]
        ));
    }
}
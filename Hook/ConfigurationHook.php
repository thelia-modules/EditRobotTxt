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
    public function onModuleConfiguration(HookRenderEvent $event): void
    {
        $config = [];

        $robots = RobotsQuery::create()->find();
        foreach ($robots as $robot) {
            $config[] = [
                'id' => $robot->getId(),
                'domain' => $robot->getDomainName(),
                'content' => $robot->getRobotsContent(),
            ];
        }

        $event->add($this->render("module_configuration.html", [
            'config' => $config
        ]));
    }
}
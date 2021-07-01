<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 22/07/2019
 * Time: 13:14
 */

namespace EditRobotTxt\Controller;


use EditRobotTxt\Model\RobotsQuery;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Controller\Front\BaseFrontController;

class RobotsController extends BaseFrontController
{
    public function getAction(RequestStack $requestStack)
    {
        $domain = $requestStack->getCurrentRequest()->getHttpHost();

        $robot = RobotsQuery::create()->findOneByDomainName('http://' . $domain);
        if ($robot === null){
            $robot = RobotsQuery::create()->findOneByDomainName('https://' . $domain);
        }
        if ($robot === null){
            $robot = RobotsQuery::create()->findOneByDomainName($domain);
        }
        if ($robot === null){
            throw new \RuntimeException('No robot.txt found for this domain name. Check your module in your backoffice.');
        }

        return new Response($robot->getRobotsContent(), 200, ["Content-Type" => "text/plain; charset=utf-8"]);
    }

}
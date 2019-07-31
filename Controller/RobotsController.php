<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 22/07/2019
 * Time: 13:14
 */

namespace EditRobotTxt\Controller;


use EditRobotTxt\Model\RobotsQuery;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Controller\Front\BaseFrontController;

class RobotsController extends BaseFrontController
{
    public function getAction()
    {
        $domain = $this->getRequest()->getHttpHost();

        $robot = RobotsQuery::create()->findOneByDomainName('http://' . $domain);
        if ($robot === null){
            $robot = RobotsQuery::create()->findOneByDomainName('https://' . $domain);
        }

        return new Response($robot->getRobotsContent(), 200, ["Content-Type" => "text/plain; charset=utf-8"]);
    }

}
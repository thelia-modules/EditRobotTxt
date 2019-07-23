<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 22/07/2019
 * Time: 13:14
 */

namespace EditRobotTxt\Controller;


use EditRobotTxt\Model\RobotsQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Controller\BaseController;

class RobotsController extends BaseAdminController
{
    public function getAction()
    {
        $domain = $this->getRequest()->getHttpHost();

        $robot = RobotsQuery::create()->findOneByDomainName($domain);


        return $this->render('robots_txt',['content'=>$robot->getRobotsContent()]);
    }

}
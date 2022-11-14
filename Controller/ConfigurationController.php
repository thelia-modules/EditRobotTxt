<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 19/07/2019
 * Time: 12:04
 */

namespace EditRobotTxt\Controller;


use Composer\EventDispatcher\Event;
use EditRobotTxt\Form\EditForm;
use EditRobotTxt\Model\Robots;
use EditRobotTxt\Model\RobotsQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Form\Lang\LangUrlEvent;
use Thelia\Tools\URL;
use function Clue\StreamFilter\append;
use function Sodium\add;

class ConfigurationController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response|null
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function editAction()
    {
        $form = new EditForm($this->getRequest());
        $response = null;

        $configForm = $this->validateForm($form);
        $indexC = 1;
        $indexD = 1;

        $config = [];

        foreach ($configForm->getData() as $id => $data){
            if (strcmp('content'.$indexC, $id) == 0){
                $robot = RobotsQuery::create()->findOneById($indexC);
                $robot->setRobotsContent($data);
                $robot->save();
                $config[$indexC][0] = $data;
                $indexC += 1;
            } elseif (strcmp('domain_name'.$indexD, $id) == 0){
                $robot = RobotsQuery::create()->findOneById($indexD);
                $robot->setDomainName($data);
                $robot->save();
                $config[$indexD][1] = $data;
                $indexD += 1;
            }
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/EditRobotTxt'));
    }
}
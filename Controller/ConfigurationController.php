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
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Form\Lang\LangUrlEvent;
use Thelia\Tools\URL;

class ConfigurationController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response|null
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function editAction()
    {
        $form = $this->createForm(EditForm::getName());

        $configForm = $this->validateForm($form);

        foreach ($configForm->getData() as $id => $data){
            if (is_int($id)){
                $robot = RobotsQuery::create()->findOneById($id);
                $robot->setRobotsContent($data);
                $robot->save();
            }
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/EditRobotTxt'));
    }
}
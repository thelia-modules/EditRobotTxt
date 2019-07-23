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

class ConfigurationController extends BaseAdminController
{
    /**
     * @return null|\Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function editAction()
    {
        $form = new EditForm($this->getRequest());
        $response = null;

        $configForm = $this->validateForm($form);

        foreach ($configForm->getData() as $id => $data){
            if (is_int($id)){
                $robot = RobotsQuery::create()->findOneById($id);
                $robot->setRobotsContent($data);
                $robot->save();
            }
        }

        $response = $this->render(
            'module-configure',
            ['module_code' => 'EditRobotTxt']
        );
        return $response;
    }
}
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

        foreach ($configForm->getData() as $fieldNameAndId => $data){
            if (!in_array($fieldNameAndId, ['success_url', 'error_url', 'error_message']) ){
                list($fieldName, $id) = explode('_', $fieldNameAndId);
                $setter = "set".$fieldName;
                $robot = RobotsQuery::create()->findOneById($id);
                $robot->$setter($data);
                $robot->save();
            }
        }
        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/EditRobotTxt'));
    }
}
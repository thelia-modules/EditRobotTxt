<?php

namespace EditRobotTxt\Controller;


use EditRobotTxt\Form\EditForm;
use EditRobotTxt\Model\RobotsQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/module/EditRobotTxt/configuration", name="editrobottxt_configuration")
 */
class ConfigurationController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response|null
     * @throws \Propel\Runtime\Exception\PropelException
     * @Route("", name="_configuration", methods="POST")
     */
    public function editAction()
    {
        $form = $this->createForm(EditForm::getName());

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
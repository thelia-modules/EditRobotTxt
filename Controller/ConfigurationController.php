<?php

namespace EditRobotTxt\Controller;


use EditRobotTxt\Form\EditForm;
use EditRobotTxt\Model\RobotsQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/module/editrobottxt/cofiguration", name="editrobottxt_cofiguration")
 */
class ConfigurationController extends BaseAdminController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response|null
     * @throws \Propel\Runtime\Exception\PropelException
     * @Route("", name="_cofiguration", methods="POST")
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
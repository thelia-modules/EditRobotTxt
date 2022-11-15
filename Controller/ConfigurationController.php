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
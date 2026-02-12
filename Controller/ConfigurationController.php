<?php

namespace EditRobotTxt\Controller;

use EditRobotTxt\Form\DeleteForm;
use EditRobotTxt\Form\EditForm;
use EditRobotTxt\Model\Robots;
use EditRobotTxt\Model\RobotsQuery;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/module/EditRobotTxt/configuration", name="editrobottxt_configuration")
 */
class ConfigurationController extends BaseAdminController
{
    /**
     * @return Response|null
     * @throws PropelException
     * @Route("", name="_configuration", methods="POST")
     */
    public function editAction(): ?Response
    {
        $form = $this->createForm(EditForm::getName());
        $configForm = $this->validateForm($form);

        $newDomain = (string) ($configForm->get('DomainName_new')->getData() ?? '');
        $newContent = (string) ($configForm->get('RobotsContent_new')->getData() ?? '');

        $newDomain = trim($newDomain);
        if ($newDomain !== '') {
            $robot = new Robots();
            $robot
                ->setDomainName($newDomain)
                ->setRobotsContent($newContent)
                ->save();
        }

        foreach ($configForm->getData() as $fieldNameAndId => $data) {
            if (in_array($fieldNameAndId, ['success_url', 'error_url', 'error_message'], true)) {
                continue;
            }

            if (str_ends_with($fieldNameAndId, '_new')) {
                continue;
            }

            [$fieldName, $id] = explode('_', $fieldNameAndId, 2);

            $robot = RobotsQuery::create()->findOneById((int) $id);
            if ($robot === null) {
                continue;
            }

            $setter = "set" . $fieldName;
            if (method_exists($robot, $setter)) {
                $robot->$setter($data);
                $robot->save();
            }
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/EditRobotTxt'));
    }

    /**
     * @return Response|null
     * @throws PropelException
     * @Route("/delete", name="_delete", methods="POST")
     */
    public function deleteAction(): ?Response
    {
        $form = $this->createForm(DeleteForm::getName());
        $deleteForm = $this->validateForm($form);

        $id = (int) $deleteForm->get('id')->getData();

        $robot = RobotsQuery::create()->findOneById($id);
        if ($robot !== null) {
            $robot->delete();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/EditRobotTxt'));
    }
}
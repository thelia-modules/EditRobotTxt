<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 19/07/2019
 * Time: 12:07
 */

namespace EditRobotTxt\Form;



use EditRobotTxt\Model\Robots;
use EditRobotTxt\Model\RobotsQuery;
use Thelia\Form\BaseForm;

class EditForm extends BaseForm
{
    const ROBOT_PREFIX = 'robot_';

    protected function buildForm()
    {
        $form = $this->formBuilder;
        /** @var Robots $domain */
        foreach (RobotsQuery::create()->find() as $domain){
            $form->add($domain->getId(),'text',[
                'data' => $domain->getRobotsContent(),
                'attr' => array(
                    'tag' => 'robot',
                    'domain' => $domain->getDomainName()
                )
            ]);
        }
    }

    public function getName()
    {
        return 'edit_robot_txt_configuration';
    }

}
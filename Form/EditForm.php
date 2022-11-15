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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Form\BaseForm;

class EditForm extends BaseForm
{
    const ROBOT_PREFIX = 'robot_';

    protected function buildForm()
    {
        $form = $this->formBuilder;
        /** @var Robots $domain */
        foreach (RobotsQuery::create()->find() as $domain){
            $form->add('RobotsContent_' . $domain->getId(),TextType::class,[
                    'data' => $domain->getRobotsContent(),
                    'attr' => array(
                        'tag' => 'robot',
                        'domain' => $domain->getDomainName()
                    )
                ])
                ->add('DomainName_' . $domain->getId(),TextType::class,[
                    'data' => $domain->getDomainName(),
                    'attr' => array(
                        'tag' => 'domain',
                        'domain' => $domain->getDomainName()
                    )
                ]);
        }
    }

    public static function getName()
    {
        return 'editrobottxt_configuration';
    }

}
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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Thelia\Form\BaseForm;

class EditForm extends BaseForm
{
    const ROBOT_PREFIX = 'robot_';

    protected function buildForm(): void
    {
        $form = $this->formBuilder;

        /** @var Robots $domain */
        foreach (RobotsQuery::create()->find() as $domain) {
            $form
                ->add('RobotsContent_' . $domain->getId(), TextareaType::class, [
                    'data' => $domain->getRobotsContent(),
                    'attr' => [
                        'tag' => 'robot',
                        'domain' => $domain->getDomainName()
                    ],
                    'required' => false,
                ])
                ->add('DomainName_' . $domain->getId(), TextType::class, [
                    'data' => $domain->getDomainName(),
                    'attr' => [
                        'tag' => 'domain',
                        'domain' => $domain->getDomainName()
                    ],
                    'required' => false,
                ]);
        }

        $form
            ->add('DomainName_new', TextType::class, [
                'data' => '',
                'required' => false,
            ])
            ->add('RobotsContent_new', TextareaType::class, [
                'data' => '',
                'required' => false,
            ]);
    }

    public static function getName(): string
    {
        return 'editrobottxt_configuration';
    }
}
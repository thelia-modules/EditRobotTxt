<?php

namespace EditRobotTxt\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Thelia\Form\BaseForm;

class DeleteForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder->add('id', HiddenType::class, [
            'required' => true,
        ]);
    }

    public static function getName(): string
    {
        return 'editrobottxt_delete';
    }
}
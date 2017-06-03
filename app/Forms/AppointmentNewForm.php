<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AppointmentNewForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text',['default_value' => $this->getData('name')])
            ->add('service_id', 'hidden', ['default_value' =>$this->getData('service_id')])
            ->add('start', 'hidden', ['default_value' =>$this->getData('start')])
            ->add('user_id', 'hidden', ['default_value' => $this->getData('user_id')])
            ->add('email', 'email',['default_value' => $this->getData('email')])
            ->add('note', 'textarea',['attr'=>['rows'=>3],
                'label'=>'Additional Notes (Optional)',
                'help_block' => [
                    'text' => 'Write additional notes for to your appointment.',
                    'tag' => 'p',
                    'attr' => ['class' => 'help-block']
                ],
            ]
            )
            ->add('submit','submit',['attr'=>['class'=>'btn btn-primary']])
        ;
    }
}

<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ServiceForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('description', 'textarea',
            	[
	            	'attr'=>['rows'=>4],
	                'label'=>'Description',
	                // 'help_block' => [
	                //     'text' => 'Describe what this service is all about.',
	                //     'tag' => 'p',
	                //     'attr' => ['class' => 'help-block']
	                // ],
            	]
            )
            
            ->add('url', 'text',
            	[
	                'label'=>'Customized URL for this service',
	                'help_block' => [
	                    'text' => 'Example. easysked.com/joebarbershop/1hr',
	                    'tag' => 'p',
	                    'attr' => ['class' => 'help-block']
	                ],
            	]
            )
            ->add('duration', 'number',
            	[
            		// 'wrapper' =>[],
            		'attr' => ['min' => 15],
            		'default_value' => 15,
	                'label'=>'Duration (in minutes)',
	                // 'help_block' => [
	                //     'text' => 'Duration of the service in minutes.',
	                //     'tag' => 'p',
	                //     'attr' => ['class' => 'help-block']
	                // ],
            	]
            )
            ->add('limit', 'number',
            	[
            		'attr' => ['min' => 1],
            		'default_value' => 1,
	                'label'=>'Number of clients per scheduled booking.',
	                'help_block' => [
	                    'text' => 'Set to more than 1 if you will accept more than 1 client per scheduled session.',
	                    'tag' => 'p',
	                    'attr' => ['class' => 'help-block']
	                ],
            	]
            )
            ->add('buffer_before', 'number',
            	[
            		'attr' => ['min' => 0],
            		'default_value' => 0,
	                'label'=>'Buffer Before',
	                'help_block' => [
	                    'text' => 'Set a buffer of minutes before start of each session.',
	                    'tag' => 'p',
	                    'attr' => ['class' => 'help-block']
	                ],
            	]
            )
            ->add('buffer_after', 'number',
            	[
            		'attr' => ['min' => 0],
            		'default_value' => 0,
	                'label'=>'Buffer After',
	                'help_block' => [
	                    'text' => 'Set a buffer of minutes after end of each session.',
	                    'tag' => 'p',
	                    'attr' => ['class' => 'help-block']
	                ],
            	]
            )
            // ->add('is_payment_required', 'checkbox',
            // 	[
	           //      'label'=>'Payment is required before booking appointment?',
	           //      // 'help_block' => [
	           //      //     'text' => 'Use this to require payment before booking appointments.',
	           //      //     'tag' => 'p',
	           //      //     'attr' => ['class' => 'help-block']
	           //      // ],
            // 	]
            // )
            // ->add('price', 'number',
            // 	[
	           //      'label'=>'Price',
	           //      'default_value' => 0,
	           //      'help_block' => [
	           //          'text' => 'Amount the client will pay for this service.',
	           //          'tag' => 'p',
	           //          'attr' => ['class' => 'help-block']
	           //      ],
            // 	]
            // )
            // ->add('minimum_payment', 'number',
            // 	[
            // 		'attr' => ['min' => 0, 'max' => 100],
	           //      'label'=>'Minimum payment required for each booking.',
	           //      'help_block' => [
	           //          'text' => 'Minimum payment (in percentage 0-100%) that is required before booking an appointment.',
	           //          'tag' => 'p',
	           //          'attr' => ['class' => 'help-block']
	           //      ],
            // 	]
            // )
            
            
            ->add('submit','submit',['attr'=>['class'=>'btn btn-primary']])
            ;
    }
}

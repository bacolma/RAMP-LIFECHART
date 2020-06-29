<?php namespace RampAssessment\Core;

$xbox->add_field( [
    'id' => 'assessment-active' ,
    'name' => __( 'This page has a Assessment Page?' , RAMP_ASSESSMENT_TEXT_DOMAIN ) ,
    'type' => 'radio' ,
    'default' => 'no' ,
    'items' => [
        'no' => 'No' ,
        'yes' => 'Yes' ,
    ] ,
] );
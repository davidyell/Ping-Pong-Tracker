<?php

App::uses('AppModel', 'Model');

/**
 * Tournament Model
 *
 */
class Tournament extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a name for this tournament',
                'required' => true
            ),
        ),
    );

}

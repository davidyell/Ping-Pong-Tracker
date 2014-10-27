<?php
App::uses('AppModel', 'Model');
/**
 * Department Model
 *
 * @property Player $Player
 */
class Department extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Player'
	];

}

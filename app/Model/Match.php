<?php
App::uses('AppModel', 'Model');
/**
 * Match Model
 *
 * @property Player $Player
 */
class Match extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $validate = array(
            
        );

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Player' => array(
			'className' => 'Player',
			'joinTable' => 'matches_players',
			'foreignKey' => 'match_id',
			'associationForeignKey' => 'player_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}

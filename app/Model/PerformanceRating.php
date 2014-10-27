<?php

App::uses('AppModel', 'Model');

/**
 * Rating Model
 *
 * @property Player $Player
 */
class PerformanceRating extends AppModel {

/**
 * Which database table will this model be attached to
 *
 * @var string
 */
	public $useTable = 'ratings';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'rating';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = [
		'Player' => [
			'className' => 'Player',
			'foreignKey' => 'player_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
		'Match'
	];

/**
 * Gets a history of the performance rating of a player over time by day
 *
 * @param int $playerId The id of the player to get history for
 * @param int $limit The limit
 * @return array CakePHP data array
 */
	public function getRatingsHistory($playerId, $limit = 30) {
		$history = $this->find('all', [
			'contain' => false,
			'conditions' => [
				'player_id' => $playerId
			],
			'fields' => [
				'SUM(rating) / COUNT(id) AS average',
				'DATE_FORMAT(created, "%Y-%m-%d") as `day`'
			],
			'group' => '`day`',
			'order' => 'created ASC',
			'limit' => $limit
		]);
		return $history;
	}

}

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
    public $belongsTo = array(
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
/**
 * Gets a history of the performance rating of a player over time by day
 * 
 * @param int $player_id
 * @return array CakePHP data array
 */
    public function getRatingsHistory($player_id, $limit = 30){
        $history = $this->find('all', array(
            'contain' => false,
            'conditions' => array(
                'player_id' => $player_id
            ),
            'fields' => array(
                'SUM(rating) / COUNT(id) AS average',
                'DATE_FORMAT(created, "%Y-%m-%d") as `day`'
            ),
            'group' => '`day`',
            'order' => 'created DESC',
            'limit' => $limit
        ));
        return $history;
    }

}

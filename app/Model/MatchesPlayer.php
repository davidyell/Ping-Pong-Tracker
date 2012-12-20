<?php
App::uses('AppModel', 'Model');
/**
 * MatchesPlayer Model
 *
 * @property Match $Match
 * @property Player $Player
 */
class MatchesPlayer extends AppModel {


	public $validate = array(
            'score'=>array(
                'one'=>array(
                    'rule'=>'notEmpty',
                    'message'=>'Please enter a score',
                    'required'=>true
                ),
                'two'=>array(
                    'rule'=>'numeric',
                    'message'=>'Please enter a number'
                )
            ),
            'Player.id'=>array(
                'one'=>array(
                    'rule'=>array('comparison', '>', 0),
                    'message'=>'Please pick a player',
                    'required'=>true
                ),
                'two'=>array(
                    'rule'=>'different',
                    'message'=>'Players must be different',
                ),
            )
        );

        public function different($check){
            var_dump($check);
            exit;
        }

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Match' => array(
			'className' => 'Match',
			'foreignKey' => 'match_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Player' => array(
			'className' => 'Player',
			'foreignKey' => 'player_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

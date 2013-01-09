<?php
App::uses('AppModel', 'Model');
/**
 * MatchesPlayer Model
 *
 * @property Match $Match
 * @property Player $Player
 */
class MatchesPlayer extends AppModel {

        public $actsAs = array('Linkable.Linkable');

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
            'player_id'=>array(
                'one'=>array(
                    'rule'=>array('comparison', '>', 0),
                    'message'=>'Please pick a player',
                    'required'=>true
                )
            )
        );

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

/**
 * Get the match details
 * @param int $id
 * @return array A cake data array of the match details with the players
 */
        public function getMatch($id){
            $match = $this->Match->find('first', array(
                'contain'=>array(
                    'MatchType',
                    'MatchesPlayer'=>array(
                        'Player'
                    )
                ),
                'conditions'=>array(
                    'Match.id'=>$id
                )
            ));
            return $match;
        }

/**
 * Find the last 'Won' or 'Lost' match for a player
 *
 * @param int $id Player id
 * @param string $type Either 'Won' or 'Lost'
 * @return array Cake data array
 */
        public function getLastResult($id, $type){
            $result = $this->find('first', array(
                'contain'=>array(
                    'Match'
                ),
                'conditions'=>array(
                    'player_id'=>$id,
                    'result'=>$type
                ),
                'order'=>'MatchesPlayer.created DESC'
            ));
            return $result;
        }

/**
 * Get a set of aggregated statistics for all the departments
 *
 * @return array
 */
        public function getDepartmentRankings(){
            $stats = $this->find('all', array(
                'link'=>array(
                    'Player'=>array(
                        'fields'=>array('department_id'),
                        'Department'=>array(
                            'fields'=>array('id','name')
                        )
                    )
                ),
                'conditions'=>array(

                ),
                'fields'=>$this->Player->stats_fields,
                'group'=>'Department.id',
                'order'=>'rank DESC'
            ));
            return $stats;
        }
}

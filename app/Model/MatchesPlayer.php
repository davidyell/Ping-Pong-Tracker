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
            'player_id'=>array(
                'one'=>array(
                    'rule'=>array('comparison', '>', 0),
                    'message'=>'Please pick a player',
                    'required'=>true
                )
            )
        );

/**
 * Lookup a collection of results for a specific player or group of players
 * @param array $player_ids
 * @return array
 */
        public function getResults($player_ids = array()){
            $results = $this->find('all', array(
                'contain'=>false,
                'conditions'=>array(
                    'player_id'=>$player_ids
                )
            ));

            $wins = 0;
            $losses = 0;
            $total_points = 0;

            if($results){
                foreach($results as $item){
                    if($item['MatchesPlayer']['result'] == 'Won'){
                        $wins++;
                    }else{
                        $losses++;
                    }
                    $total_points += $item['MatchesPlayer']['score'];
                }
            }

            return array('wins'=>$wins, 'losses'=>$losses, 'total_score'=>$total_points);
        }

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

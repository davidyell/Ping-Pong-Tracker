<?php
App::uses('AppModel', 'Model');
/**
 * Player Model
 *
 * @property Department $Department
 * @property Match $Match
 */
class Player extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'first_name';

/**
 * Gets list of players as an array for a select in the format David Y
 * @return array An array of players by FirstName and Surname initial
 */
        public function getPlayers(){
            $players = $this->find('all', array(
                'contain'=>false,
                'fields'=>array('id','first_name','last_name')
            ));

            foreach($players as $p){
                $return[$p['Player']['id']] = $p['Player']['first_name'].' '.substr($p['Player']['last_name'], 0, 1);
            }

            $return[0] = 'Choose player';

            return $return;
        }

/**
 * Generates an array of players with calculated ranks and stats
 * @return array An array of players and stats
 */
        public function getRankings(){
            $rankings = $this->MatchesPlayer->find('all', array(
                'contain'=>array(
                    'Player'=>array(
                        'fields'=>array('id','first_name','nickname','last_name')
                    )
                ),
                'conditions'=>array(

                ),
                'fields'=>array( // TODO: Perhaps simplfy the math somehow to avoid this repetition
                    'SUM(if(result = "Won", 1, 0)) as wins',
                    'SUM(if(result = "Lost", 1, 0)) as losses',
                    'COUNT(MatchesPlayer.id) as total_matches',
                    'SUM(score) as total_score',
                    'SUM(if(result = "Won", score, 0)) as win_points',
                    'SUM(if(result = "Won", 1, 0)) / ( SUM(if(result = "Won", 1, 0)) + SUM(if(result = "Lost", 1, 0)) ) * 100 as win_percent',
                    '(SUM(if(result = "Won", score, 0)) * SUM(if(result = "Won", 1, 0))) / SUM(if(result = "Lost", 1, 0)) as rank', /* (won_points * wins) / losses */
                ),
                'group'=>'player_id',
                'order'=>'rank DESC'
            ));

            // Move anyone with a NULL rating to the top, as that's the best you can get
            foreach($rankings as $k => $player){
                if($player[0]['rank'] == null){
                    $rankings[$k][0]['rank'] = 9001; // over 9000!
                }
            }

            // http://stackoverflow.com/questions/2699086/sort-multidimensional-array-by-value-2
            // For some reason this returns the ranks in reverse order, but that's okay.
            usort($rankings, function($a, $b) {
                return $a[0]['rank'] - $b[0]['rank'];
            });

            return $rankings;
        }

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


        public $hasMany = array(
            'MatchesPlayer'
        );

}

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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = [
			'Department' => [
				'className' => 'Department',
				'foreignKey' => 'department_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			]
	];

/**
 * hasMany associations
 *
 * @var array
 */
		public $hasMany = [
			'MatchesPlayer',
			'PerformanceRating'
		];

/**
 * An array of fields used to generate statistics for players
 * TODO: Perhaps simplfy the math somehow to avoid this repetition?
 *
 * @var array
 */
		public $stats_fields = [
			'SUM(if(result = "Won", 1, 0)) as wins',
			'SUM(if(result = "Lost", 1, 0)) as losses',
			'SUM(if(result = "Won", score, 0)) - SUM(if(result = "Lost", score, 0)) as diff',
			'COUNT(DISTINCT(MatchesPlayer.match_id)) as total_matches',
			'SUM(score) as total_score',
			'SUM(if(result = "Won", score, 0)) as win_points',
			'SUM(if(result = "Won", 1, 0)) / ( SUM(if(result = "Won", 1, 0)) + SUM(if(result = "Lost", 1, 0)) ) * 100 as win_percent',
			'(SUM(if(result = "Won", score, 0)) * SUM(if(result = "Won", 1, 0))) / SUM(if(result = "Lost", 1, 0)) as rank', /* (won_points * wins) / losses */
		];

/**
 * Gets list of players as an array for a select in the format David Y
 *
 * @param bool $choose If the choose a player should be included or not
 * @return array An array of players by FirstName and Surname initial
 */
		public function getPlayers($choose = true){
			$players = $this->find('all', [
				'contain'=>false,
				'fields'=>['id','first_name','last_name'],
				'order'=>'first_name'
			]);

			foreach($players as $p){
				$return[$p['Player']['id']] = $p['Player']['first_name'].' '.substr($p['Player']['last_name'], 0, 1);
			}

			if($choose){
				$return[0] = 'Choose player';
			}

			return $return;
		}

/**
 * Generates an array of players with calculated ranks and stats
 *
 * @return array An array of players and stats
 */
		public function getRankings(){
			$rankings = $this->MatchesPlayer->find('all', [
				'contain'=>[
					'Player'=>[
						'fields'=>['id','first_name','nickname','last_name','email','facebook_id','performance_rating']
					]
				],
				'conditions'=>[

				],
				'fields'=>$this->stats_fields,
				'group'=>'player_id',
				'order'=>'rank DESC'
			]);

			foreach($rankings as $k => $player){
				if($player[0]['rank'] == null){
					$rankings[$k][0]['rank'] = 100; // No change, reset to default rating
				}
			}

			 // Sort the array, as anyone undefeated will have a rating divided by zero
			 // http://stackoverflow.com/questions/2699086/sort-multidimensional-array-by-value-2
			usort($rankings, function($a, $b) {
				return $a[0]['rank'] - $b[0]['rank'];
			});

			// For some reason this ^ returns the ranks in reverse order, but that's okay.
			$rankings = array_reverse($rankings);

			return $rankings;
		}

/**
 * Gets a players matches ordered by date over the last 30 days for display as a graph
 *
 * @param int $player_id
 * @return array Cake data array
 */
		public function winsOverTime($player_id, $days = 30){
			$data = $this->MatchesPlayer->find('all', [
				'contain'=>false,
				'conditions'=>[
					'player_id'=>$player_id,
				],
				'fields'=>[
					'SUM(if(result = "Won", 1, 0)) as wins',
					'SUM(if(result = "Lost", 1, 0)) as losses',
					'DATE_FORMAT(created, "%a %D %b") as day'
				],
				'group'=>'day',
				'order'=>'created ASC',
				'limit'=>$days
			]);
			return $data;
		}

/**
 * Returns a set of stats for a single player
 *
 * @param int $player_id
 * @return array
 */
		public function getPlayerStats($player_id){
			$player = $this->find('all', [
				'contain'=>[
					'MatchesPlayer'=>[
						'fields'=>$this->stats_fields // TODO: Figure out why this is generating an extra dimension - $player['MatchesPlayer'][0]['MatchesPlayer'][0]['wins']
					],
					'Department'=>[
						'fields'=>['id','name']
					]
				],
				'conditions'=>[
					'Player.id'=>$player_id
				]
			]);
			return $player;
		}

/**
 * Calculates the head to head statistics for all matches between players.
 *
 * @param array $players EG, array(id1, id2)
 * @return array
 */
		public function getHeadToHead($players = []){
			$matches = $this->MatchesPlayer->find('all', [
				'contain'=>[
					'Match'
				],
				'conditions'=>[
					'player_id'=>$players,
					'match_type_id'=>1
				],
				'fields'=>[
					'match_id',
					'COUNT(match_id) AS players'
				],
				'group'=>'match_id HAVING players = '.count($players), // Allows us to load doubles and singles
			]);

			foreach($matches as $match){
				$match_ids[] = $match['MatchesPlayer']['match_id'];
			}

			$stats = $this->MatchesPlayer->find('all', [
				'contain'=>[
					'Player'=>[
						'fields'=>[
							'id',
							'first_name',
							'nickname',
							'last_name',
							'email'
						]
					],
				],
				'conditions'=>[
					'match_id'=>$match_ids
				],
				'fields'=>$this->stats_fields,
				'group'=>'player_id'
			]);

			return $stats;
		}

/**
 * Updates a players record with the newly calculated singles performance rating
 *
 * @param int $player_id
 * @param int $rating
 */
		public function updatePerformanceRating($player_id, $rating){
			$this->id = $player_id;
			if(!$this->exists()){
				throw new NotFoundException('Not a valid player');
			}
			$this->recursive = -1;
			$this->data = $this->read(null, $player_id);
			$this->data['Player']['performance_rating'] = $rating;
			$this->save();
		}
}

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
 * belongsTo associations
 *
 * @var array
 */
		public $belongsTo = [
			'MatchType',
			'Tournament'
		];

/**
 * Variable for storing the Elo Ratings once they've been calculated
 *
 * @var array
 */
		public $ratings = [];

/**
 * The name of the method that we are using in the controller
 *
 * @var string
 */
		public $method = '';

/**
 * beforeValidate callback method
 *
 * @param array $options
 */
		public function beforeValidate($options = []) {
			parent::beforeValidate($options);

			$this->unsetBlankPlayers();
			$this->findWinner();

			// We only need to copy if it's doubles
			if ($this->data['Match']['match_type_id'] == 2) {
				$this->assignScores();
			}
		}

/**
 * afterSave callback method
 *
 * @param type $created
 */
		public function afterSave($created, $options = []) {
			parent::afterSave($created);

			// Are we adding a new match and only singles matches
			if(isset($this->method) && $this->method == 'add' && $this->data['Match']['match_type_id'] == 1) {
				$this->doEloRating();
			}
		}

/**
 * Will calculate the new performance rating for two players for a single match.
 *
 * @return void
 */
		public function doEloRating(){
			$vendor = App::path('Vendor');
			require_once($vendor[0].'EloRating'.DS.'EloRating.php');

			$this->MatchesPlayer->Player->recursive = -1;
			$ratingA = $this->MatchesPlayer->Player->read(['id','performance_rating','first_name','last_name'], $this->data['MatchesPlayer'][1]['MatchesPlayer']['player_id']);
			$ratingB = $this->MatchesPlayer->Player->read(['id','performance_rating','first_name','last_name'], $this->data['MatchesPlayer'][2]['MatchesPlayer']['player_id']);

			$scores = $this->getScore($this->data['MatchesPlayer']);

			$rating = new Rating($ratingA['Player']['performance_rating'], $ratingB['Player']['performance_rating'], $scores['a'], $scores['b']);

			// Store the ratings in the model so we can display them
			$this->ratings = [
				'a' => [
					'id' => $ratingA['Player']['id'],
					'name' => $ratingA['Player']['first_name'].' '.substr($ratingA['Player']['last_name'], 0, 1),
					'oldRating' => $ratingA['Player']['performance_rating'],
					'newRating' => $rating->newRatingA
				],
				'b' => [
					'id' => $ratingB['Player']['id'],
					'name' => $ratingB['Player']['first_name'].' '.substr($ratingB['Player']['last_name'], 0, 1),
					'oldRating' => $ratingB['Player']['performance_rating'],
					'newRating' => $rating->newRatingB
				]
			];

			$this->MatchesPlayer->Player->updatePerformanceRating($ratingA['Player']['id'], $rating->newRatingA);
			$this->MatchesPlayer->Player->updatePerformanceRating($ratingB['Player']['id'], $rating->newRatingB);
		}

/**
 * Set the score
 *
 * @param array $result
 * @return array
 */
		public function getScore($result) {
			$return = [];

			if ($result[1]['MatchesPlayer']['score'] > $result[2]['MatchesPlayer']['score']) {
				$return['a'] = 1;
				$return['b'] = 0;
			} elseif ($result[1]['MatchesPlayer']['score'] < $result[2]['MatchesPlayer']['score']) {
				$return['a'] = 0;
				$return['b'] = 1;
			}

			return $return;
		}

/**
 * Process the current data and remove any players which have an id of 0. Which will remove the spare doubles players
 *
 * @return void
 */
	private function unsetBlankPlayers() {
		if (isset($this->data['MatchesPlayer'])) {
			foreach ($this->data['MatchesPlayer'] as $i => $player) {
				if ($i > 2 && $player['player_id'] == 0) {
					unset($this->data['MatchesPlayer'][$i]);
				}
			}
		}
	}

/**
 * Find out which person or pair won the match and make a note of it to save time on display later
 *
 * @return void
 */
	private function findWinner() {
		if (isset($this->data['MatchesPlayer'])) {
			if ($this->data['MatchesPlayer'][1]['score'] > $this->data['MatchesPlayer'][2]['score']) {
				$this->data['MatchesPlayer'][1]['result'] = 'Won';
				$this->data['MatchesPlayer'][2]['result'] = 'Lost';
			} elseif ($this->data['MatchesPlayer'][1]['score'] < $this->data['MatchesPlayer'][2]['score']) {
				$this->data['MatchesPlayer'][1]['result'] = 'Lost';
				$this->data['MatchesPlayer'][2]['result'] = 'Won';
			} else {
				$this->data['MatchesPlayer'][1]['result'] = 'Drawn';
				$this->data['MatchesPlayer'][2]['result'] = 'Drawn';
			}
		}
	}

/**
 * Copy the scores and results from the first pair of players to the doubles players
 *
 * @return void
 */
		private function assignScores() {
			 // Doubles - 4 players (1+3) v (2+4)
			$this->data['MatchesPlayer'][3]['score'] = $this->data['MatchesPlayer'][1]['score'];
			$this->data['MatchesPlayer'][3]['result'] = $this->data['MatchesPlayer'][1]['result'];

			$this->data['MatchesPlayer'][4]['score'] = $this->data['MatchesPlayer'][2]['score'];
			$this->data['MatchesPlayer'][4]['result'] = $this->data['MatchesPlayer'][2]['result'];
		}

/**
 * Builds an executes a query to find the total number of singles and doubles matches played
 *
 * @return array A cakephp data array
 */
		private function matchBreakdown() {
			$db = $this->getDataSource();

			$subQuery = $db->buildStatement(
					[
						'fields'=>['match_id','match_type_id'],
						'table'=>$db->fullTableName($this->MatchesPlayer),
						'alias'=>'MatchesPlayer',
						'joins'=>[
							'JOIN `matches` AS `Match` ON `Match`.`id` = `MatchesPlayer`.`match_id`'
						],
						'group'=>'match_id'
					],
					$this->MatchesPlayer
				);

			$query = $db->buildStatement(
					[
						'fields'=>[
							'SUM(IF(match_type_id = 2, 1, 0)) as doubles',
							'SUM(IF(match_type_id = 1, 1, 0)) as singles'
							],
						'table'=>'('.$subQuery.')',
						'alias'=>'grouped_matches',
					],
					$this->MatchesPlayer
				);

			return $this->query($query);
		}

/**
 * Finds and aggregates global statistics for the whole system
 *
 * @return array Formatted array of Cake data arrays
 */
		public function getGlobalStats() {

			// Matches played, scores, etc
			$stats = $this->MatchesPlayer->find('all', [
				'contain'=>false,
				'fields'=>$this->MatchesPlayer->Player->stats_fields
			]);

			// Matches played by day
			$matches_by_day = $this->find('all', [
				'contain'=>false,
				'conditions'=>[

				],
				'fields'=>[
					'DATE_FORMAT(created, "%W") as `day`',
					'DATE_FORMAT(created, "%w") as `daynum`',
					'COUNT(id) as matches'
				],
				'group'=>'day',
				'order'=>'daynum'
			]);

			// Last few days with the most matches won
			$most_matches = $this->find('all', [
				'contain'=>false,
				'conditions'=>[

				],
				'fields'=>[
					'DATE_FORMAT(created, "%Y-%m-%d") as `day`',
					'COUNT(id) as matches'
				],
				'group'=>'day',
				'order'=>'matches DESC',
				'limit'=>3
			]);

			// Latest highest scoring match of all time
			$match_id = $this->MatchesPlayer->find('first', [
				'contain'=>false,
				'fields'=>['match_id'],
				'order'=>'score DESC, created DESC'
			]);

			$high_score_match = $this->find('first', [
				'contain'=>[
					'MatchesPlayer'=>[
						'Player'
					],
					'MatchType'=>[
						'fields'=>['id', 'name']
					]
				],
				'conditions'=>[
					'Match.id'=>$match_id['MatchesPlayer']['match_id']
				]
			]);

			// Doubles and singles
			$return['match_types'] = $this->matchBreakdown();

			// Format arrays for return
			$return['highest_match_score'] = $high_score_match;
			$return['stats'] = $stats[0][0];
			$return['matches_by_day'] = $matches_by_day;
			$return['most_played_days'] = $most_matches;

			return $return;
		}

}

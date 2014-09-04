<?php

App::uses('AppController', 'Controller');

App::import('Vendor','knockout-tournament-scheduler/class_knockout');

/**
 * Matches Controller
 *
 * @property Match $Match
 */
class MatchesController extends AppController {

/**
 * Load the components we need for this controller
 *
 * @var array An array of components
 */
	public $components = ['RequestHandler'];

/**
 * Method to aggregate Performance Ratings from all historic matches
 */
	public function updateRatings(){
		if (Configure::read('debug') != 2) {
			throw new ForbiddenException('Cannot update match PR history');
		}

		$matches = $this->Match->find('all', [
			'contain'=>[
				'MatchesPlayer'
			],
			'conditions'=>[
				'Match.match_type_id'=>1
			]
		]);

		$i = 1;
		foreach($matches as $match){

			$vendor = App::path('Vendor');
			require_once($vendor[0].'EloRating'.DS.'EloRating.php');

			$this->Match->MatchesPlayer->Player->recursive = -1;
			$ratingA = $this->Match->MatchesPlayer->Player->read(['id','performance_rating'], $match['MatchesPlayer'][0]['player_id']);
			$ratingB = $this->Match->MatchesPlayer->Player->read(['id','performance_rating'], $match['MatchesPlayer'][1]['player_id']);

			if ($match['MatchesPlayer'][0]['score'] > $match['MatchesPlayer'][1]['score']) {
				$scores['a'] = 1;
				$scores['b'] = 0;
			} elseif ($match['MatchesPlayer'][0]['score'] < $match['MatchesPlayer'][1]['score']) {
				$scores['a'] = 0;
				$scores['b'] = 1;
			}

			$rating = new Rating($ratingA['Player']['performance_rating'], $ratingB['Player']['performance_rating'], $scores['a'], $scores['b']);

			$this->Match->MatchesPlayer->Player->updatePerformanceRating($ratingA['Player']['id'], $rating->newRatingA);
			$this->Match->MatchesPlayer->Player->updatePerformanceRating($ratingB['Player']['id'], $rating->newRatingB);

			$ratings = [
				[
					'player_id' => $ratingA['Player']['id'],
					'rating' => $rating->newRatingA,
					'match_id' => $match['Match']['id'],
					'change' => $rating->newRatingA - $ratingA['Player']['performance_rating'],
					'created' => $match['Match']['created'],
					'modified' => $match['Match']['modified'],
				],
				[
					'player_id' => $ratingB['Player']['id'],
					'match_id' => $match['Match']['id'],
					'change' => $rating->newRatingB - $ratingB['Player']['performance_rating'],
					'rating' => $rating->newRatingB,
					'created' => $match['Match']['created'],
					'modified' => $match['Match']['modified'],
				],
			];
			$this->Match->MatchesPlayer->Player->PerformanceRating->saveAll($ratings);

			$i++;
		}

		var_dump('Done!. Processed '.$i.' matches.');
		$this->render(false);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => [
				'MatchType',
				'MatchesPlayer' => [
					'Player'
				]
			],
			'order' => 'Match.created DESC'
		];
		$this->set('matches', $this->paginate());

		if ($this->request->is('ajax')) {
			$this->render('/Elements/matches-index-table', 'ajax');
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Match->id = $id;
		if (!$this->Match->exists()) {
			throw new NotFoundException(__('Invalid match'));
		}
		$match = $this->Match->find('first', [
			'contain' => [
				'MatchesPlayer' => [
					'Player'
				],
				'MatchType'
			],
			'conditions' => [
				'Match.id' => $id
			]
				]);
		$this->set('match', $match);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->Match->method = 'add'; // Controls the calculation of the Elo Rating

		if ($this->request->is('post')) {

			// Do we need to remember the details for the user to add again?
			if (isset($this->request->data['Match']['remember'])) {
				$this->Session->write('match', $this->request->data);
				$this->Session->delete('match.Match.notes');

				// Remove the scores
				$this->Session->delete('match.MatchesPlayer.1.score');
				$this->Session->delete('match.MatchesPlayer.2.score');
			} elseif ($this->Session->check('match')) {
				$this->Session->delete('match');
			}

			// Copy the scores to the model for validation
			$this->Match->MatchesPlayer->matchScores = [$this->request->data['MatchesPlayer'][1]['score'], $this->request->data['MatchesPlayer'][2]['score']];

			$this->Match->create();
			if ($this->Match->saveAll($this->request->data)) {

				if($this->request->data['Match']['match_type_id'] == 1){
					// Save the players PR for historic comparison
					$ratings = [
						[
							'player_id' => $this->Match->ratings['a']['id'],
							'rating' => $this->Match->ratings['a']['newRating'],
							'match_id' => $this->Match->getInsertID(),
							'change' => $this->Match->ratings['a']['newRating'] - $this->Match->ratings['a']['oldRating']
						],
						[
							'player_id' => $this->Match->ratings['b']['id'],
							'rating' => $this->Match->ratings['b']['newRating'],
							'match_id' => $this->Match->getInsertID(),
							'change' => $this->Match->ratings['b']['newRating'] - $this->Match->ratings['b']['oldRating']
						],
					];
					$this->Match->MatchesPlayer->Player->PerformanceRating->saveAll($ratings);

					// Display the PR difference
					$message = $this->Match->ratings['a']['name'].' '.sprintf("%+d", number_format($this->Match->ratings['a']['newRating'] - $this->Match->ratings['a']['oldRating'], 0));
					$message .= '&nbsp;|&nbsp;';
					$message .= $this->Match->ratings['b']['name'].' '.sprintf("%+d", number_format($this->Match->ratings['b']['newRating'] - $this->Match->ratings['b']['oldRating'], 0));

					$this->Session->setFlash('Match saved. [ '.$message.' ]', 'alert-box', ['class' => 'alert-success']);
				}else{
					$this->Session->setFlash('The match has been saved successfully.', 'alert-box', ['class' => 'alert-success']);
				}
				$this->redirect(['action' => 'add']);
			} else {
				$this->Session->setFlash(__('The match could not be saved. Please, try again.'), 'alert-box', ['class' => 'alert-error']);
			}
		}

		if ($this->Session->check('match')) {
			$this->request->data = $this->Session->read('match');
		}

		$players = $this->Match->MatchesPlayer->Player->getPlayers(false);

		$matchTypes = $this->Match->MatchType->find('list');

		$this->set(compact('players', 'matchTypes'));
	}

/**
 * Get a set of global statistics
 *
 * @return void
 */
	public function global_stats() {
		$this->set('stats', $this->Match->getGlobalStats());
	}

/**
 * Get a list of recent matches for a player
 *
 * @param int $playerId
 * @throws NotFoundException
 * @return array Paginated Cake data array - only when requested
 */
	public function match_history($playerId){
		if(!$this->Match->MatchesPlayer->Player->exists($playerId)){
			throw new NotFoundException('Player not found');
		}

		$this->Match->MatchesPlayer->Player->recursive = -1;
		$this->set('player', $this->Match->MatchesPlayer->Player->read(['id','first_name','nickname','last_name'], $playerId));

		$matchIds = $this->Match->MatchesPlayer->find('list', [
			'contain' => false,
			'conditions' => [
				'MatchesPlayer.player_id'=>$playerId
			],
			'fields' => ['match_id']
		]);

		$this->paginate = [
			'contain' => [
				'MatchesPlayer' => [
					'Player' => [
						'fields' => ['id','first_name','last_name'],
					]
				],
				'MatchType' => [
					'fields' => ['id','name']
				]
			],
			'conditions' => [
				'Match.id' => $matchIds
			],
			'order' => 'Match.created DESC',
			'limit' => 10
		];

		if($this->request->is('requested')){
			return $this->paginate();
		}else{
			$this->set('matches', $this->paginate());
		}

	}

/**
 * Edit method
 * Called when saving tournament matches through ajax
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function ajax_edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$validation = [];
			$updateDraw = '';

			// We need to set the scores to the model to allow validation
			$this->Match->MatchesPlayer->matchScores = [(int)$this->request->data['MatchesPlayer'][1]['score'], (int)$this->request->data['MatchesPlayer'][2]['score']];

			if ($this->Match->saveAll($this->request->data)) {
				$updateDraw = $this->requestAction(['controller'=>'tournaments', 'action'=>'update_draw', $this->request->data['Tournament']['id']]);
				$outcome = 'Success';
			} else {
				$outcome = 'Failed';
				$validation = $this->Match->validationErrors;
			}

			$this->set(compact('outcome','validation','updateDraw'));
			$this->set('_serialize', ['outcome','validation','updateDraw']);
		}
	}

}

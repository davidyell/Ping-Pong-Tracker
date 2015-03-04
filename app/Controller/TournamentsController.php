<?php
/**
 * CakePHP TournamentController
 * @author david
 */
App::uses('AppController', 'Controller');
App::import('Vendor', 'Knockout', ['file' => 'knockout-tournament-scheduler' . DS . 'class_knockout.php']);

class TournamentsController extends AppController {

/**
 * Load the components we need for this controller
 *
 * @var array An array of components
 */
	public $components = ['RequestHandler'];

/**
 * Find and paginate a list of tournaments
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => [
				'Match' => [
					'order' => 'tournament_round DESC',
					'limit' => 1,
					'MatchesPlayer' => [
						'fields' => ['id', 'result', 'player_id'],
						'conditions' => [
							'result' => 'Won'
						],
						'Player' => [
							'fields' => ['id', 'first_name', 'nickname', 'last_name']
						]
					]
				]
			],
			'conditions' => [

			],
			'order' => 'created DESC'
		];
		$this->set('tournaments', $this->paginate());
	}

/**
 * Create a new tournament on the system
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$error = false;

			// Save the tournament
			$this->request->data['Tournament']['competitors'] = serialize($this->Session->read('Tournament.competitors'));
			if (!$this->Tournament->save($this->request->data['Tournament'])) {
				$error = true;
			}
			$tournamentId = $this->Tournament->getLastInsertId();

			// Move the image
			if (file_exists(ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournament.png')) {
				mkdir(ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournaments' . DS . $tournamentId, 0775, true);
				rename(ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournament.png', ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournaments' . DS . $tournamentId . DS . 'tournament_' . $tournamentId . '.png');
			}

			$matches = $this->Tournament->jsonRoundsToArray($this->request->data['Tournament']['rounds'], $tournamentId);

			foreach ($matches as $match) {
				$this->Tournament->Match->create();
				if (!$this->Tournament->Match->saveAll($match, ['validate' => false])) {
					$error = true;
				}
			}

			if ($error) {
				$this->Session->setFlash(__('The tournament could not be saved. Please, try again.'), 'alert-box', ['class' => 'alert-error']);
			} else {
				$this->redirect(['action' => 'play', $tournamentId]);
			}

		}

		$this->loadModel('Player');
		$this->set('players', $this->Player->getPlayers(false));
	}

/**
 * Create a set of brackets from a collection of players
 * This will also save an image of the draw and return a json object of rounds
 *
 * @return string A json string of the rounds to be played
 */
	public function draw() {
		if ($this->request->is('ajax')) {
			$this->loadModel('Player');
			$competitors = $this->Player->find('all', [
				'contain' => false,
				'conditions' => [
					'id' => $this->request->data['Tournament']['selected_players']
				],
				'fields' => ['id', 'first_name', 'last_name'],
				'order' => 'RAND()'
			]);

			$data = [];
			foreach ($competitors as $player) {
				$data[$player['Player']['id']] = "(" . $player['Player']['id'] . ") " . $player['Player']['first_name'] . " " . substr($player['Player']['last_name'], 0, 1);
			}

			// As we need to instantiate the Knockout class in the same way each
			// time we use it to manage the tournament, we will need to store the
			// competitors
			$this->Session->write('Tournament.competitors', $data);

			$tournament = new KnockoutGD($data);

			$image = $tournament->getImage($this->request->data['Tournament']['name']);
			$source = imagepng($image, ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournament.png');

			$rounds = $tournament->getBracket();
			$this->set('rounds', $rounds);
			$this->set('_serialize', ['rounds']);
		}
	}

/**
 * Resolves the matches for a tournament round
 * Single matches are posted to Matches::edit() via Ajax
 *
 * @param int $tournamentId The id of the tournament
 * @return void
 */
	public function play($tournamentId) {
		$tournament = $this->Tournament->find('first', [
			'contain' => [
				'Match' => [
					'MatchesPlayer' => [
						'conditions' => [
							'result' => ''
						],
						'Player' => [
							'fields' => ['id', 'first_name', 'nickname', 'last_name', 'email', 'facebook_id', 'performance_rating']
						]
					]
				]
			],
			'conditions' => [
				'Tournament.id' => $tournamentId,
			]
		]);

		// Bit of a hack to reorder the data from the above query. It will remove
		// and played matches and reindex the matches
		// TODO: Refactor into model.
		foreach ($tournament['Match'] as $num => $match) {
			if (empty($match['MatchesPlayer'])) {
				unset($tournament['Match'][$num]);
			}
		}
		$tournament['Match'] = array_values($tournament['Match']);

		$this->set(compact('tournament'));
	}

/**
 * Update the draw image for a tournament using played matches
 *
 * @param int $tournamentId The tournament to draw for
 * @return bool
 */
	public function update_draw($tournamentId) {
		$tourney = $this->Tournament->find('first', [
			'contain' => [
				'Match' => [
					'MatchesPlayer' => [
						'conditions' => [
							'score >' => -1
						]
					]
				]
			],
			'conditions' => [
				'Tournament.id' => $tournamentId
			]
		]);

		$tournament = new KnockoutGD(unserialize($tourney['Tournament']['competitors']));

		// Mark matches as played
		foreach ($tourney['Match'] as &$match) {

			if (!empty($match['MatchesPlayer'])) {

				// Set the scores if they happen to be zero
				if (!isset($match['MatchesPlayer'][0]['score'])) {
					$match['MatchesPlayer'][0]['score'] = 0;
				}
				if (!isset($match['MatchesPlayer'][1]['score'])) {
					$match['MatchesPlayer'][1]['score'] = 0;
				}

				$tournament->setResByMatch((int)$match['tournament_match_num'], (int)$match['tournament_round'], (int)$match['MatchesPlayer'][0]['score'], (int)$match['MatchesPlayer'][1]['score']);
			}
		}

		// Generate the new draw image with played results
		$image = $tournament->getImage($tourney['Tournament']['name']);
		imagepng($image, ROOT . DS . WEBROOT_DIR . DS . 'files' . DS . 'tournaments' . DS . $tournamentId . DS . 'tournament_' . $tournamentId . '.png');

		// Gather up the brackets and results we have so far
		$rounds = $tournament->getBracket();

		// Have we completed a bracket? With all matches having been played?
		$complete = [];
		foreach ($rounds as $round => $matches) {
			foreach ($matches as $matchNum => $match) {
				if ($tournament->isMatchPlayed($matchNum, $round)) {
					$complete[$round] = true;
				} else {
					$complete[$round] = false;
				}
			}
		}

		// Generate matches for the next round
		if (!empty($complete)) {
			$error = false;

			foreach ($complete as $round => $played) {
				if (!$played) {

					// Look to see if the matches have already been generated
					$nextRoundMatches = $this->Tournament->Match->find('first', [
						'contain' => false,
						'conditions' => [
							'tournament_id' => $tournamentId,
							'tournament_round' => $round
						]
					]);

					if (!$nextRoundMatches) {
						$fixtures = $this->Tournament->knockoutRoundsToArray($rounds[$round], $round, $tournamentId);

						foreach ($fixtures as $match) {
							$this->Tournament->Match->create();
							if (!$this->Tournament->Match->saveAll($match, ['validate' => false])) {
								$error = true;
							}
						}

						if ($error) {
							return false;
						} else {
							return true;
						}
					}

					break;
				}
			}

		}
	}

}
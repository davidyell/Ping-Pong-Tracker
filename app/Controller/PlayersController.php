<?php

App::uses('AppController', 'Controller');

/**
 * Players Controller
 *
 * @property Player $Player
 */
class PlayersController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => [
				'Department'
			],
			'order' => 'first_name'
		];
		$this->set('players', $this->paginate());
	}

/**
 * Rankings method
 *
 * @return void
 */
	public function rankings() {
		$this->set('rankings', $this->Player->getRankings());
	}

/**
 * view method
 *
 * @param string $id The id of the player to view
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		$this->Player->id = $id;
		if (!$this->Player->exists()) {
			throw new NotFoundException(__('Invalid player'));
		}

		$player = $this->Player->find('first', [
			'contain' => [
				'Department'
			],
			'conditions' => [
				'Player.id' => $id
			]
				]);
		$this->set('player', $player);

		$lastWinId = $this->Player->MatchesPlayer->getLastResult($id, 'Won');
		if ($lastWinId) {
			$this->set('lastWin', $this->Player->MatchesPlayer->getMatch($lastWinId['Match']['id']));
		}

		$lastLossId = $this->Player->MatchesPlayer->getLastResult($id, 'Lost');
		if ($lastLossId) {
			$this->set('lastLoss', $this->Player->MatchesPlayer->getMatch($lastLossId['Match']['id']));
		}

		$results = $this->Player->getPlayerStats($id);
		$this->set('results', $results);

		// Get ranking history
		$this->set('ratingbytime', $this->Player->PerformanceRating->getRatingsHistory($id));

		$this->set('winsbytime', $this->Player->winsOverTime($id));
	}

/**
 * Compare the played games of two players
 *
 * @return void
 */
	public function head_to_head() {
		if ($this->request->is('post')) {
			if ($this->request->data['Player']['player1'] == $this->request->data['Player']['player2']) {
				$this->Session->setFlash('You can\'t compare youself to yourself.', 'alert-box', ['class' => 'alert-error']);
				$this->redirect(['action' => 'head_to_head']);
			}

			$this->redirect(['action' => 'head_to_head', $this->request->data['Player']['player1'], $this->request->data['Player']['player2']]);
		}

		if (!empty($this->request->params['pass'][0]) && !empty($this->request->params['pass'][1])) {
			$players = $this->Player->getHeadToHead([$this->request->params['pass'][0], $this->request->params['pass'][1]]);
			$this->set(compact('players'));

			$this->request->data['Player']['player1'] = $this->request->params['pass'][0];
			$this->request->data['Player']['player2'] = $this->request->params['pass'][1];
		} else {
			$this->request->data['Player']['player1'] = 0;
			$this->request->data['Player']['player2'] = 0;
		}

		$this->set('playerList', $this->Player->getPlayers());
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Player->recursive = 0;
		$this->set('players', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id The id of the item to view
 * @throws NotFoundException
 * @return void
 */
	public function admin_view($id = null) {
		$this->Player->id = $id;
		if (!$this->Player->exists()) {
			throw new NotFoundException(__('Invalid player'));
		}
		$this->set('player', $this->Player->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Player->create();
			if ($this->Player->save($this->request->data)) {
				$this->Session->setFlash(__('The player has been saved'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The player could not be saved. Please, try again.'));
			}
		}
		$departments = $this->Player->Department->find('list');
		$this->set(compact('departments'));
	}

/**
 * admin_edit method
 *
 * @param string $id The id of the item to edit
 * @throws NotFoundException
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Player->id = $id;
		if (!$this->Player->exists()) {
			throw new NotFoundException(__('Invalid player'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Player->save($this->request->data)) {
				$this->Session->setFlash(__('The player has been saved'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Session->setFlash(__('The player could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Player->read(null, $id);
		}
		$departments = $this->Player->Department->find('list');
		$this->set(compact('departments'));
	}

/**
 * admin_delete method
 *
 * @param string $id The id of the item to delete
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Player->id = $id;
		if (!$this->Player->exists()) {
			throw new NotFoundException(__('Invalid player'));
		}
		if ($this->Player->delete()) {
			$this->Session->setFlash(__('Player deleted'));
			$this->redirect(['action' => 'index']);
		}
		$this->Session->setFlash(__('Player was not deleted'));
		$this->redirect(['action' => 'index']);
	}

}

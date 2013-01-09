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
		$this->Player->recursive = 0;
		$this->set('players', $this->paginate());
	}

/**
 * Rankings method
 * @return void
 */
        public function rankings(){
            $this->set('rankings', $this->Player->getRankings());
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Player->id = $id;
		if (!$this->Player->exists()) {
			throw new NotFoundException(__('Invalid player'));
		}

                $player = $this->Player->find('first', array(
                    'contain'=>array(
                        'Department'
                    ),
                    'conditions'=>array(
                        'Player.id'=>$id
                    )
                ));
                $this->set('player',$player);

                $last_win_id = $this->Player->MatchesPlayer->getLastResult($id, 'Won');
                if($last_win_id){
                    $this->set('last_win', $this->Player->MatchesPlayer->getMatch($last_win_id['Match']['id']));
                }

                $last_loss_id = $this->Player->MatchesPlayer->getLastResult($id, 'Lost');
                if($last_loss_id){
                    $this->set('last_loss', $this->Player->MatchesPlayer->getMatch($last_loss_id['Match']['id']));
                }

                $results = $this->Player->getPlayerStats($id);
                $this->set('results', $results);

                $this->set('winsbytime', $this->Player->winsOverTime($id));

	}

/**
 * Compare the stats of two players
 *
 * @return void
 */
        public function compare(){

            if($this->request->is('post')){
                $player1 = $this->Player->getPlayerStats($this->request->data['Player']['player1']);
                $player2 = $this->Player->getPlayerStats($this->request->data['Player']['player2']);
                $this->set(compact('player1','player2'));
            }else{
                $this->request->data['Player']['player1'] = 0;
                $this->request->data['Player']['player2'] = 0;
            }

            $this->set('player_list', $this->Player->getPlayers());
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
 * @throws NotFoundException
 * @param string $id
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
				$this->redirect(array('action' => 'index'));
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
 * @throws NotFoundException
 * @param string $id
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
				$this->redirect(array('action' => 'index'));
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
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
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
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Player was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}

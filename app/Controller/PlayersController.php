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
                        'Department',
                    ),
                    'conditions'=>array(
                        'Player.id'=>$id
                    )
                ));
		$this->set('player', $player);

                // TODO: I think this could be better organised, as it's _way_ too nested
                $matches = $this->Player->MatchesPlayer->find('all', array(
                    'contain'=>array(
                        'Match'=>array(
                            'MatchType',
                            'MatchesPlayer'=>array(
                                'Player'=>array(
                                    'fields'=>array('id','first_name','nickname','last_name')
                                )
                            )
                        )
                    ),
                    'conditions'=>array(
                        'MatchesPlayer.player_id'=>$id
                    ),
                    'order'=>'Match.created DESC'
                ));
                $this->set('matches',$matches);

                $winloss = $this->Player->MatchesPlayer->find('all', array(
                    'contain'=>false,
                    'conditions'=>array(
                        'MatchesPlayer.player_id'=>$id
                    )
                ));

                $wins = 0;
                $losses = 0;
                $score_total = 0;
                foreach($winloss as $item){
                    if($item['MatchesPlayer']['result'] == 'Lost'){
                        $losses++;
                    }else{
                        $wins++;
                    }
                    $score_total += $item['MatchesPlayer']['score'];
                }

                $this->set(compact('wins','losses','score_total'));

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

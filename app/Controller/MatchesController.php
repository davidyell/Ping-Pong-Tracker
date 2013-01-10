<?php

App::uses('AppController', 'Controller');

/**
 * Matches Controller
 *
 * @property Match $Match
 */
class MatchesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index(){
        $this->paginate = array(
            'contain'=>array(
                'MatchType',
                'MatchesPlayer'=>array(
                    'Player'
                )
            ),
            'order'=>'Match.created DESC'
        );
        $this->set('matches', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null){
        $this->Match->id = $id;
        if(!$this->Match->exists()){
            throw new NotFoundException(__('Invalid match'));
        }
        $match = $this->Match->find('first', array(
            'contain'=>array(
                'MatchesPlayer'=>array(
                    'Player'
                ),
                'MatchType'
            ),
            'conditions'=>array(
                'Match.id'=>$id
            )
        ));
        $this->set('match', $match);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add(){

        if($this->request->is('post')){

            // Do we need to remember the details for the user to add again?
            if(isset($this->request->data['Match']['remember'])){
                $this->Session->write('match', $this->request->data);

                // Remove the scores
                $this->Session->delete('match.MatchesPlayer.1.score');
                $this->Session->delete('match.MatchesPlayer.2.score');
            }elseif($this->Session->check('match')){
                $this->Session->delete('match');
            }

            $this->Match->create();
            if($this->Match->saveAll($this->request->data)){
                $this->Session->setFlash(__('The match has been saved'), 'alert-box', array('class'=>'alert-success'));
                $this->redirect(array('action'=>'add'));
            } else{
                $this->Session->setFlash(__('The match could not be saved. Please, try again.'), 'alert-box', array('class'=>'alert-error'));
            }
        }

        if($this->Session->check('match')){
            $this->request->data = $this->Session->read('match');
        }

        $players = $this->Match->MatchesPlayer->Player->getPlayers();

        $matchTypes = $this->Match->MatchType->find('list');

        $this->set(compact('players','matchTypes'));
    }

    public function global_stats(){
        $this->set('stats', $this->Match->getGlobalStats());
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index(){
        $this->Match->recursive = 0;
        $this->set('matches', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null){
        $this->Match->id = $id;
        if(!$this->Match->exists()){
            throw new NotFoundException(__('Invalid match'));
        }
        $this->set('match', $this->Match->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add(){
        if($this->request->is('post')){
            $this->Match->create();
            if($this->Match->save($this->request->data)){
                $this->Session->setFlash(__('The match has been saved'));
                $this->redirect(array('action'=>'index'));
            } else{
                $this->Session->setFlash(__('The match could not be saved. Please, try again.'));
            }
        }
        $players = $this->Match->Player->find('list');
        $this->set(compact('players'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null){
        $this->Match->id = $id;
        if(!$this->Match->exists()){
            throw new NotFoundException(__('Invalid match'));
        }
        if($this->request->is('post') || $this->request->is('put')){
            if($this->Match->save($this->request->data)){
                $this->Session->setFlash(__('The match has been saved'));
                $this->redirect(array('action'=>'index'));
            } else{
                $this->Session->setFlash(__('The match could not be saved. Please, try again.'));
            }
        } else{
            $this->request->data = $this->Match->read(null, $id);
        }
        $players = $this->Match->Player->find('list');
        $this->set(compact('players'));
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null){
        if(!$this->request->is('post')){
            throw new MethodNotAllowedException();
        }
        $this->Match->id = $id;
        if(!$this->Match->exists()){
            throw new NotFoundException(__('Invalid match'));
        }
        if($this->Match->delete()){
            $this->Session->setFlash(__('Match deleted'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Match was not deleted'));
        $this->redirect(array('action'=>'index'));
    }

}

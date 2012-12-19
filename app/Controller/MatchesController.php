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
        $this->Match->recursive = 0;
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
        $this->set('match', $this->Match->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add(){
        if($this->request->is('post')){

            $this->Match->create();
            if($this->Match->saveAll($this->request->data)){
                $this->Session->setFlash(__('The match has been saved'), 'alert-box', array('class'=>'alert-success'));
                $this->redirect(array('action'=>'index'));
            } else{
                $this->Session->setFlash(__('The match could not be saved. Please, try again.'), 'alert-box', array('class'=>'alert-error'));
            }
        }
        $players = $this->Match->MatchesPlayer->Player->find('list');
        $players[0] = 'Choose player';
        $this->set(compact('players'));
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

<?php
/**
 * CakePHP TournamentController
 * @author david
 */

App::uses('AppController', 'Controller');
App::import('Vendor','knockout-tournament-scheduler/class_knockout');

class TournamentsController extends AppController {
    
    public function example() {
        
        $this->loadModel('Player');
        $competitors = $this->Player->find('list', array(
            'contain' => false,
            'limit' => 10
        ));
        
        $tournament = new KnockoutGD($competitors);
        
        $im = $tournament->getImage("Tournament name here");
        $source = imagepng($im, APP.WEBROOT_DIR.DS.'img'.DS.'tournament1.png');
        
        $tournament->setResByCompets('David', 'Steve', 1, 0);
        
        $im = $tournament->getImage("Tournament name here");
        $source = imagepng($im, APP.WEBROOT_DIR.DS.'img'.DS.'tournament2.png');
        
    }
    
    public function add() {
        
        $this->loadModel('Player');
        $this->set('players', $this->Player->getPlayers(false));
    }
    
    public function draw() {
        if($this->request->is('ajax')){
            $this->loadModel('Player');
            $competitors = $this->Player->find('list', array(
                'contain' => false,
                'conditions' => array(
                    'id' => $this->request->data['Tournament']['selected_players']
                )
            ));

            $tournament = new KnockoutGD($competitors);

            $im = $tournament->getImage($this->request->data['Tournament']['name']);
            $source = imagepng($im, APP.WEBROOT_DIR.DS.'img'.DS.'tournament.png');
        }
        
        $this->render(false, 'ajax');
    }
        
}
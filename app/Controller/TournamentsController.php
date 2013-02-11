<?php
/**
 * CakePHP TournamentController
 * @author david
 */

App::uses('AppController', 'Controller');
App::import('Vendor','knockout-tournament-scheduler/class_knockout');

class TournamentsController extends AppController {
    
/**
 * Load the components we need for this controller
 * 
 * @var array An array of components
 */
    public $components = array('RequestHandler');
    
    public function index() {
        $this->Tournament->recursive = -1;
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
            $this->request->data['Tournament']['competitors'] = serialize($this->request->data['Tournament']['selected_players']);
            if (!$this->Tournament->save($this->request->data['Tournament'])) {
                $error = true;
            }
            $tournamentId = $this->Tournament->getLastInsertId();
            
            // Move the image
            if (file_exists(APP.WEBROOT_DIR.DS.'files'.DS.'tournament.png')) {
                mkdir(APP.WEBROOT_DIR.DS.'files'.DS.'tournaments'.DS.$tournamentId);
                rename(APP.WEBROOT_DIR.DS.'files'.DS.'tournament.png', APP.WEBROOT_DIR.DS.'files'.DS.'tournaments'.DS.$tournamentId.DS.'tournament_'.$tournamentId.'.png');
            }
            
            // Save the matches - this is in a loop because saveAll on the 
            // parent model didn't save associated model data
            $matches = $this->Tournament->jsonRoundsToArray($this->request->data['Tournament']['rounds'], $tournamentId);
            foreach ($matches as $match) {
                $this->Tournament->Match->create();
                if ($this->Tournament->Match->saveAll($match, array('validate'=>false))) {
                    $error = true;
                }
            }
            
            if ($error === false) {
                $this->Session->setFlash(__('The tournament could not be saved. Please, try again.'), 'alert-box', array('class' => 'alert-error'));
            } else {
                $this->redirect(array('action' => 'play', $tournamentId));
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
        if($this->request->is('ajax')){
            $this->loadModel('Player');
            $competitors = $this->Player->find('all', array(
                'contain' => false,
                'conditions' => array(
                    'id' => $this->request->data['Tournament']['selected_players']
                ),
                'fields' => array('id', 'first_name', 'last_name'),
                'order' => 'RAND()'
            ));
            
            foreach($competitors as $player){
                $data[$player['Player']['id']] = "(".$player['Player']['id'].") ".$player['Player']['first_name']." ".substr($player['Player']['last_name'], 0, 1);
            }
            
            /**
             * As we need to instantiate the Knockout class in the same way each
             * time we use it to manage the tournament, we will need to store the 
             * competitors
             */
            $this->Session->write('Tournament.competitors', $data);

            $tournament = new KnockoutGD($data);

            $image = $tournament->getImage($this->request->data['Tournament']['name']);
            $source = imagepng($image, APP.WEBROOT_DIR.DS.'files'.DS.'tournament.png');
            
            $rounds = $tournament->getBracket();
            $this->set('rounds', $rounds);
            $this->set('_serialize', array('rounds'));
        }
    }
    
    public function play($tournamentId){
        $tournament = $this->Tournament->find('first', array(
            'contain' => array(
                'Match' => array(
                    'MatchesPlayer' => array(
                        'Player' => array(
                            'fields' => array('id','first_name','nickname','last_name','email','facebook_id','performance_rating')
                        )
                    )
                )
            ),
            'conditions' => array(
                'Tournament.id' => $tournamentId
            )
        ));
        $this->set(compact('tournament'));
    }
        
}
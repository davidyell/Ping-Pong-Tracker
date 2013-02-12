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
    
/**
 * Find and paginate a list of tournaments
 * 
 * @return void
 */
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
            $this->request->data['Tournament']['competitors'] = serialize($this->Session->read('Tournament.competitors'));
            if (!$this->Tournament->save($this->request->data['Tournament'])) {
                $error = true;
            }
            $tournamentId = $this->Tournament->getLastInsertId();
            
            // Move the image
            if (file_exists(APP.WEBROOT_DIR.DS.'files'.DS.'tournament.png')) {
                mkdir(APP.WEBROOT_DIR.DS.'files'.DS.'tournaments'.DS.$tournamentId);
                rename(APP.WEBROOT_DIR.DS.'files'.DS.'tournament.png', APP.WEBROOT_DIR.DS.'files'.DS.'tournaments'.DS.$tournamentId.DS.'tournament_'.$tournamentId.'.png');
            }
            
            $matches = $this->Tournament->jsonRoundsToArray($matches, $tournamentId);

            foreach ($matches as $match) {
                $this->Tournament->Match->create();
                if ($this->Tournament->Match->saveAll($match, array('validate'=>false))) {
                    $error = true;
                }
            }
            
            if ($error) {
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
            
            $data = array();
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
    
/**
 * Resolves the matches for a tournament round
 * Single matches are posted to Matches::edit() via Ajax
 * 
 * @param int $tournamentId
 */
    public function play($tournamentId){
        $tournament = $this->Tournament->find('first', array(
            'contain' => array(
                'Match' => array(
                    'MatchesPlayer' => array(
                        'conditions' => array(
                            'result' => ''
                        ),
                        'Player' => array(
                            'fields' => array('id','first_name','nickname','last_name','email','facebook_id','performance_rating')
                        )
                    )
                )
            ),
            'conditions' => array(
                'Tournament.id' => $tournamentId,
            )
        ));
        var_dump($tournament);
        $this->set(compact('tournament'));
    }
    
/**
 * Update the draw image for a tournament using played matches
 * 
 * @param int $tournamentId
 */
    public function update_draw($tournamentId) {
        $tourney = $this->Tournament->find('first', array(
            'contain' => array(
                'Match' => array(
                    'MatchesPlayer' => array(
                        'conditions' => array(
                            'score >' => 0
                        )
                    )
                )
            ),
                ));

        $tournament = new KnockoutGD(unserialize($tourney['Tournament']['competitors']));

        // Mark matches as played
        foreach ($tourney['Match'] as $matchNum => $match) {
            if (!empty($match['MatchesPlayer'])) {

                // Set the scores if they happen to be zero
                if (!isset($match['MatchesPlayer'][0]['score'])) {
                    $score1 = 0;
                } else {
                    $score1 = $match['MatchesPlayer'][0]['score'];
                }
                if (!isset($match['MatchesPlayer'][1]['score'])) {
                    $score1 = 0;
                } else {
                    $score2 = $match['MatchesPlayer'][1]['score'];
                }
                $tournament->setResByMatch($matchNum, $match['tournament_round'], (int) $score1, (int) $score2);
            }
        }

        // Generate the new draw image with played results
        $image = $tournament->getImage($tourney['Tournament']['name']);
        imagepng($image, APP.WEBROOT_DIR.DS.'files'.DS.'tournaments'.DS.$tournamentId.DS.'tournament_'.$tournamentId.'.png');

        // Gather up the brackets and results we have so far
        $rounds = $tournament->getBracket();

        // Have we completed a bracket? With all matches having been played?
        $complete = array();
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
                    $nextRoundMatches = $this->Tournament->Match->find('first', array(
                        'contain' => false,
                        'conditions' => array(
                            'tournament_id' => $tournamentId,
                            'tournament_round' => $round
                        )
                    ));
                    
                    if (!$nextRoundMatches) {
                        $fixtures = $this->Tournament->knockoutRoundsToArray($rounds[$round], $round, $tournamentId);

                        foreach ($fixtures as $match) {
                            $this->Tournament->Match->create();
                            if ($this->Tournament->Match->saveAll($match, array('validate'=>false))) {
                                $error = true;
                            }
                        }

                        if ($error) {
                            $this->Session->setFlash(__('The tournament could not be saved. Please, try again.'), 'alert-box', array('class' => 'alert-error'));
                        } else {
                            $this->redirect(array('action' => 'play', $tournamentId));
                        }
                    }
                    
                    break;
                }
            }
            
        }
    }
        
}
<?php
App::uses('AppModel', 'Model');
/**
 * Match Model
 *
 * @property Player $Player
 */
class Match extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

        public function beforeValidate($options = array()){
            parent::beforeValidate($options);

            $this->_unsetBlankPlayers();
            
            $this->_findWinner();

            // We only need to copy if it's doubles
            if($this->data['Match']['match_type_id'] == 2){
                $this->_assignScores();
            }
        }

/**
 * Process the current data and remove any players which have an id of 0. Which will remove the spare doubles players
 */
        private function _unsetBlankPlayers(){
            foreach($this->data['MatchesPlayer'] as $i => $player){
                if($i > 2 && $player['player_id'] == 0){
                    unset($this->data['MatchesPlayer'][$i]);
                }
            }
        }

/**
 * Find out which person or pair won the match and make a note of it to save time on display later
 */
        private function _findWinner(){
            if($this->data['MatchesPlayer'][1]['score'] > $this->data['MatchesPlayer'][2]['score']){
                $this->data['MatchesPlayer'][1]['result'] = 'Won';
                $this->data['MatchesPlayer'][2]['result'] = 'Lost';
            }elseif($this->data['MatchesPlayer'][1]['score'] < $this->data['MatchesPlayer'][2]['score']){
                $this->data['MatchesPlayer'][1]['result'] = 'Lost';
                $this->data['MatchesPlayer'][2]['result'] = 'Won';
            }else{
                $this->data['MatchesPlayer'][1]['result'] = 'Drawn';
                $this->data['MatchesPlayer'][2]['result'] = 'Drawn';
            }
        }

/**
 * Copy the scores and results from the first pair of players to the doubles players
 */
        private function _assignScores(){
             // Doubles - 4 players (1+3) v (2+4)
            $this->data['MatchesPlayer'][3]['score'] = $this->data['MatchesPlayer'][1]['score'];
            $this->data['MatchesPlayer'][3]['result'] = $this->data['MatchesPlayer'][1]['result'];

            $this->data['MatchesPlayer'][4]['score'] = $this->data['MatchesPlayer'][2]['score'];
            $this->data['MatchesPlayer'][4]['result'] = $this->data['MatchesPlayer'][2]['result'];
        }

        public $hasMany = array(
            'MatchesPlayer'
        );

        public $belongsTo = array(
            'MatchType'
        );

}

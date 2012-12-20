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

            // Unset any blank players
            $this->_unsetBlankPlayers();

            // Copy player_id's
            if($this->data['Match']['match_type_id'] == 2){
                $this->_assignScores();
            }

        }

        private function _unsetBlankPlayers(){
            foreach($this->data['MatchesPlayer'] as $i => $player){
                if($i > 2 && $player['player_id'] == 0){
                    unset($this->data['MatchesPlayer'][$i]);
                }
            }
        }

        private function _assignScores(){
             // Doubles - 4 players (1+3) v (2+4)
            $this->data['MatchesPlayer'][3]['score'] = $this->data['MatchesPlayer'][1]['score'];
            $this->data['MatchesPlayer'][4]['score'] = $this->data['MatchesPlayer'][2]['score'];
        }

        public $hasMany = array(
            'MatchesPlayer'
        );

        public $belongsTo = array(
            'MatchType'
        );

}

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
            $this->_assignScores();

        }

        private function _unsetBlankPlayers(){
            foreach($this->data['Player'] as $i => $player){
                if($i > 2 && $player['id'] == 0){
                    unset($this->data['Player'][$i]);
                }
            }
        }

        private function _assignScores(){
            if($this->data['Match']['match_type_id'] == 1){ // Singles - two players
                foreach($this->data['Player'] as $k => $player){
                    $this->data['MatchesPlayer'][$k]['player_id'] = $player['id'];
                }
            }else{ // Doubles - 4 players (1+3) v (2+4)
                $this->data['MatchesPlayer'][1]['player_id'] = $this->data['Player'][1]['id'];
                $this->data['MatchesPlayer'][2]['player_id'] = $this->data['Player'][2]['id'];

                $this->data['MatchesPlayer'][3]['score'] = $this->data['MatchesPlayer'][1]['score'];
                $this->data['MatchesPlayer'][3]['player_id'] = $this->data['Player'][3]['id'];

                $this->data['MatchesPlayer'][4]['score'] = $this->data['MatchesPlayer'][2]['score'];
                $this->data['MatchesPlayer'][4]['player_id'] = $this->data['Player'][4]['id'];
            }
        }

        public $hasMany = array(
            'MatchesPlayer'
        );

        public $belongsTo = array(
            'MatchType'
        );

}

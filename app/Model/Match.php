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

	public $validate = array(
            
        );

        public function beforeValidate($options = array()){
            parent::beforeValidate($options);

            // Unset any blank players
            foreach($this->data['Player'] as $i => $player){
                if($player['id'] == 0){
                    unset($this->data['Player'][$i]);
                }
            }

            // Copy player_id's
            if(count($this->data['Player']) == 2){ // Singles - two players
                foreach($this->data['Player'] as $k => $player){
                    $this->data['MatchesPlayer'][$k]['player_id'] = $player['id'];
                }
            }else{ // Doubles - 4 players
                
            }

            exit(var_dump($this->data));
        }

        public $hasMany = array(
            'MatchesPlayer'
        );

        public $belongsTo = array(
            'MatchType'
        );

}

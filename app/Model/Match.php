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
            
        }

        public function beforeSave($options = array()){
            parent::beforeSave($options);

            // Assign a player_id to the score
            foreach($this->data['Player'] as $k => $player){
                $this->data['MatchesPlayer'][$k]['MatchesPlayer']['player_id'] = $player['id'];
            }
            exit(var_dump($this->data));
        }

        public $hasMany = array(
            'MatchesPlayer'
        );

}

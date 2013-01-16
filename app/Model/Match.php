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

/**
 * hasMany associations
 *
 * @var array
 */
        public $hasMany = array(
            'MatchesPlayer'
        );

/**
 * belongsTo associations
 *
 * @var array
 */
        public $belongsTo = array(
            'MatchType'
        );

/**
 * beforeValidate callback method
 *
 * @param array $options
 */
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
 *
 * @return void
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
 *
 * @return void
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
 *
 * @return void
 */
        private function _assignScores(){
             // Doubles - 4 players (1+3) v (2+4)
            $this->data['MatchesPlayer'][3]['score'] = $this->data['MatchesPlayer'][1]['score'];
            $this->data['MatchesPlayer'][3]['result'] = $this->data['MatchesPlayer'][1]['result'];

            $this->data['MatchesPlayer'][4]['score'] = $this->data['MatchesPlayer'][2]['score'];
            $this->data['MatchesPlayer'][4]['result'] = $this->data['MatchesPlayer'][2]['result'];
        }

/**
 * Finds and aggregates global statistics for the whole system
 *
 * @return array Formatted array of Cake data arrays
 */
        public function getGlobalStats(){

            // Matches played, scores, etc
            $stats = $this->MatchesPlayer->find('all', array(
                'contain'=>false,
                'fields'=>$this->MatchesPlayer->Player->stats_fields
            ));

            // Matches played by day
            $matches_by_day = $this->find('all', array(
                'contain'=>false,
                'conditions'=>array(

                ),
                'fields'=>array(
                    'DATE_FORMAT(created, "%W") as `day`',
                    'DATE_FORMAT(created, "%w") as `daynum`',
                    'COUNT(id) as matches'
                ),
                'group'=>'day',
                'order'=>'daynum'
            ));

            // Last few days with the most matches won
            $most_matches = $this->find('all', array(
                'contain'=>false,
                'conditions'=>array(

                ),
                'fields'=>array(
                    'DATE_FORMAT(created, "%Y-%m-%d") as `day`',
                    'COUNT(id) as matches'
                ),
                'group'=>'day',
                'order'=>'matches DESC',
                'limit'=>3
            ));

            // Latest highest scoring match of all time
            $match_id = $this->MatchesPlayer->find('first', array(
                'contain'=>false,
                'fields'=>array('match_id'),
                'order'=>'score DESC, created DESC'
            ));

            $high_score_match = $this->find('first', array(
                'contain'=>array(
                    'MatchesPlayer'=>array(
                        'Player'
                    ),
                    'MatchType'=>array(
                        'fields'=>array('id', 'name')
                    )
                ),
                'conditions'=>array(
                    'Match.id'=>$match_id['MatchesPlayer']['match_id']
                )
            ));

            // Format arrays for return
            $return['highest_match_score'] = $high_score_match;
            $return['stats'] = $stats[0][0];
            $return['matches_by_day'] = $matches_by_day;
            $return['most_played_days'] = $most_matches;
            
            return $return;
        }

}

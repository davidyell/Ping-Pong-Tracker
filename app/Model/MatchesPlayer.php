<?php

App::uses('AppModel', 'Model');

/**
 * MatchesPlayer Model
 *
 * @property Match $Match
 * @property Player $Player
 */
class MatchesPlayer extends AppModel {

/**
 * Attach behaviours
 *
 * @var array
 */
    public $actsAs = array('Linkable.Linkable');

/**
 * Configure validation rules
 * @var array
 */
    public $validate = array(
        'score' => array(
            'one' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a score',
                'required' => true
            ),
            'two' => array(
                'rule' => 'numeric',
                'message' => 'Please enter a number'
            ),
            'three' => array(
                'rule' => 'scores',
                'message' => 'Scores must be valid'
            )
        ),
        'player_id' => array(
            'one' => array(
                'rule' => array('comparison', '>', 0),
                'message' => 'Please pick a player',
                'required' => true
            )
        )
    );

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'Match' => array(
            'className' => 'Match',
            'foreignKey' => 'match_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
/**
 * A variable to store the scores for validation
 * 
 * @var array 
 */
    public $matchScores = array();
    
/**
 * Validates a pingpong score using score values saved in the model 
 * 
 * @param array $check Consists of 'field'=>'value'
 * @return boolean
 */
    public function scores($check) {
        // Scores cannot match
        if ($this->matchScores[0] == $this->matchScores[1]) {
            return false;
        }
        
        // Must score 11 or more
        if ($this->matchScores[0] < 11 && $this->matchScores[1] < 11) {
            return false;
        }
        
        // If more than 11, ensure 2 point difference
        if ($this->matchScores[0] > 11 || $this->matchScores[1] > 11) {
            // Player 1 wins
            if ($this->matchScores[0] > $this->matchScores[1]) {
                // Player 2 score must be two less than Player 1s
                if($this->matchScores[0] - 2 != $this->matchScores[1]){
                    return false;
                }
            // Player 2 wins
            } elseif ($this->matchScores[1] > $this->matchScores[0]) {
                // Player 1 score must be two less than Player 2s
                if($this->matchScores[1] - 2 != $this->matchScores[0]){
                    return false;
                }
            }
        }
        
        return true;
    }

/**
 * Get the match details
 * 
 * @param int $id
 * @return array A cake data array of the match details with the players
 */
    public function getMatch($id) {
        $match = $this->Match->find('first', array(
            'contain' => array(
                'MatchType',
                'MatchesPlayer' => array(
                    'Player'
                )
            ),
            'conditions' => array(
                'Match.id' => $id
            )
                ));
        return $match;
    }

/**
 * Find the last 'Won' or 'Lost' match for a player
 *
 * @param int $id Player id
 * @param string $type Either 'Won' or 'Lost'
 * @return array Cake data array
 */
    public function getLastResult($id, $type) {
        $result = $this->find('first', array(
            'contain' => array(
                'Match'
            ),
            'conditions' => array(
                'player_id' => $id,
                'result' => $type
            ),
            'order' => 'MatchesPlayer.created DESC'
                ));
        return $result;
    }

/**
 * Get a set of aggregated statistics for all the departments
 *
 * @param int $id The department id
 * @return array
 */
    public function getDepartmentRankings($id = null) {

        if (isset($id)) {
            $conditions = array('Department.id' => $id);
        } else {
            $conditions = array();
        }

        $stats = $this->find('all', array(
            'link' => array(
                'Player' => array(
                    'fields' => array('department_id'),
                    'Department' => array(
                        'fields' => array('id', 'name')
                    )
                )
            ),
            'conditions' => $conditions,
            'fields' => $this->Player->stats_fields,
            'group' => 'Department.id',
            'order' => 'rank DESC'
                ));
        return $stats;
    }

}

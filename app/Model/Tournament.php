<?php

App::uses('AppModel', 'Model');

/**
 * Tournament Model
 *
 */
class Tournament extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a name for this tournament',
                'required' => true
            ),
        ),
    );
    
/**
 * hasMany associations
 * 
 * @var array 
 */
    public $hasMany = array(
        'Match'
    );

/**
 * Converts a json string of data into a cake compatible data array for saving into the db
 * 
 * @param string $data A JSON data string
 * @param int $tournamentId The id of the tournament these matches are for
 * @return array CakePHP data array
 */
    public function jsonRoundsToArray($data, $tournamentId) {
        $decodedData = json_decode($data);

        $return = array();
        $round = 1;
        
        foreach ($decodedData->rounds as $matches) {
            
            $matchNum = 0;
            foreach ($matches as $match) {
                
                if(!empty($match->c1) && !empty($match->c2)){
                    
                    $return[$matchNum]['Match']['match_type_id'] = 1;
                    $return[$matchNum]['Match']['tournament_round'] = $round;

                    $return[$matchNum]['Match']['tournament_id'] = (int)$tournamentId;
                    
                    preg_match('/\(([0-9]+)\)/i', $match->c1, $ids);
                    $return[$matchNum]['MatchesPlayer'][1]['player_id'] = (int)$ids[1];
                    $return[$matchNum]['MatchesPlayer'][1]['score'] = 0;
                    
                    preg_match('/\(([0-9]+)\)/i', $match->c2, $ids);
                    $return[$matchNum]['MatchesPlayer'][2]['player_id'] = (int)$ids[1];
                    $return[$matchNum]['MatchesPlayer'][2]['score'] = 0;

                    $matchNum++;
                }
            }
            $round++;
        }

        return $return;
    }

}

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
	public $validate = [
		'name' => [
			'notempty' => [
				'rule' => ['notEmpty'],
				'message' => 'Please enter a name for this tournament',
				'required' => true
			],
		],
	];

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = [
		'Match'
	];

/**
 * Converts a json string of data into a cake compatible data array for saving into the db
 *
 * @param string $data A JSON data string
 * @param int $tournamentId The id of the tournament these matches are for
 * @return array CakePHP data array
 */
	public function jsonRoundsToArray($data, $tournamentId) {
		$decodedData = json_decode($data);

		$return = [];

		$matchNumber = 0;
		foreach ($decodedData->rounds as $round => $matches) {
			foreach ($matches as $matchNum => $match) {
				if(!empty($match->c1) && !empty($match->c2)){

					$return[$matchNumber]['Match']['match_type_id'] = 1;
					$return[$matchNumber]['Match']['tournament_round'] = $round;
					$return[$matchNumber]['Match']['tournament_match_num'] = $matchNum;

					$return[$matchNumber]['Match']['tournament_id'] = (int)$tournamentId;

					preg_match('/\(([0-9]+)\)/i', $match->c1, $ids);
					$return[$matchNumber]['MatchesPlayer'][1]['player_id'] = (int)$ids[1];
					$return[$matchNumber]['MatchesPlayer'][1]['score'] = 0;

					preg_match('/\(([0-9]+)\)/i', $match->c2, $ids);
					$return[$matchNumber]['MatchesPlayer'][2]['player_id'] = (int)$ids[1];
					$return[$matchNumber]['MatchesPlayer'][2]['score'] = 0;

				}
				$matchNumber++;
			}

			// Find out if there is a play-in round as we want to ignore other rounds
			// untill this first preliminary round has been played as we
			// generate matches on a round by round basis
			if (isset($decodedData->rounds[0])) {
				break;
			}

		}
		return $return;
	}

/**
 * Converts an array from the Knockout class into a set of matches as a Cake
 * array which can then be saved
 *
 * @param array $rounds
 * @param int $roundNum
 * @param int $tournamentId
 * @return array
 */
	public function knockoutRoundsToArray($rounds, $roundNum, $tournamentId){
		$return = [];

		foreach ($rounds as $num => $matches) {
			$return[$num]['Match']['match_type_id'] = 1;
			$return[$num]['Match']['tournament_round'] = $roundNum;
			$return[$num]['Match']['tournament_match_num'] = $num;
			$return[$num]['Match']['tournament_id'] = (int)$tournamentId;

			preg_match('/\(([0-9]+)\)/i', $matches['c1'], $ids);
			$return[$num]['MatchesPlayer'][1]['player_id'] = (int)$ids[1];
			$return[$num]['MatchesPlayer'][1]['score'] = 0;

			preg_match('/\(([0-9]+)\)/i', $matches['c2'], $ids);
			$return[$num]['MatchesPlayer'][2]['player_id'] = (int)$ids[1];
			$return[$num]['MatchesPlayer'][2]['score'] = 0;
		}
		return $return;
	}

}

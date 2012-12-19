<?php
/**
 * MatchesPlayerFixture
 *
 */
class MatchesPlayerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'match_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'player_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'score' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'match_id' => 1,
			'player_id' => 1,
			'score' => 1
		),
	);

}

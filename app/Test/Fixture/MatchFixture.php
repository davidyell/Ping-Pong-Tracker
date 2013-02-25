<?php
/**
 * MatchFixture
 *
 */
class MatchFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'match_type_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tournament_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'tournament_round' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'tournament_match_num' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'match_type_id' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 1,
			'tournament_round' => 1,
			'tournament_match_num' => 1,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 2,
			'match_type_id' => 2,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 2,
			'tournament_round' => 2,
			'tournament_match_num' => 2,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 3,
			'match_type_id' => 3,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 3,
			'tournament_round' => 3,
			'tournament_match_num' => 3,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 4,
			'match_type_id' => 4,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 4,
			'tournament_round' => 4,
			'tournament_match_num' => 4,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 5,
			'match_type_id' => 5,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 5,
			'tournament_round' => 5,
			'tournament_match_num' => 5,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 6,
			'match_type_id' => 6,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 6,
			'tournament_round' => 6,
			'tournament_match_num' => 6,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 7,
			'match_type_id' => 7,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 7,
			'tournament_round' => 7,
			'tournament_match_num' => 7,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 8,
			'match_type_id' => 8,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 8,
			'tournament_round' => 8,
			'tournament_match_num' => 8,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 9,
			'match_type_id' => 9,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 9,
			'tournament_round' => 9,
			'tournament_match_num' => 9,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
		array(
			'id' => 10,
			'match_type_id' => 10,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tournament_id' => 10,
			'tournament_round' => 10,
			'tournament_match_num' => 10,
			'created' => '2013-02-25 14:51:14',
			'modified' => '2013-02-25 14:51:14'
		),
	);

}

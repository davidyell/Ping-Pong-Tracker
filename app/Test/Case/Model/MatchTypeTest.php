<?php
App::uses('MatchType', 'Model');

/**
 * MatchType Test Case
 *
 */
class MatchTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.match_type',
		'app.match',
		'app.matches_player',
		'app.player',
		'app.department'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MatchType = ClassRegistry::init('MatchType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MatchType);

		parent::tearDown();
	}

}

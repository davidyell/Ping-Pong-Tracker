<?php
App::uses('MatchesPlayer', 'Model');

/**
 * MatchesPlayer Test Case
 *
 */
class MatchesPlayerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.matches_player',
		'app.match',
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
		$this->MatchesPlayer = ClassRegistry::init('MatchesPlayer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MatchesPlayer);

		parent::tearDown();
	}

}

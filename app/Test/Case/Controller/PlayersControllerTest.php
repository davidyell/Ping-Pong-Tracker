<?php
App::uses('PlayersController', 'Controller');

/**
 * PlayersController Test Case
 *
 */
class PlayersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.player',
		'app.department',
		'app.match',
		'app.matches_player'
	);

}

<?php

App::uses('Match', 'Model');

/**
 * Match Test Case
 *
 */
class MatchTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
    public $fixtures = array(
        'app.match',
        'app.player',
        'app.matches_player'
    );

/**
 * setUp method
 *
 * @return void
 */
    public function setUp() {
        parent::setUp();
        $this->Match = ClassRegistry::init('Match');
    }

/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown() {
        unset($this->Match);

        parent::tearDown();
    }

/**
 * Provides data for test
 * 
 * @return array
 */
    public function getScoreProvider() {
        return array(
            array(
                array(
                    1 => array(
                        'MatchesPlayer' => array(
                            'score' => 11
                        )
                    ),
                    2 => array(
                        'MatchesPlayer' => array(
                            'score' => 9
                        )
                    ),
                ),
                array(
                    'a' => 1,
                    'b' => 0
                ),
                "Expected player 1 to be victorious"
            ),
            array(
                array(
                    1 => array(
                        'MatchesPlayer' => array(
                            'score' => 3
                        )
                    ),
                    2 => array(
                        'MatchesPlayer' => array(
                            'score' => 11
                        )
                    ),
                ),
                array(
                    'a' => 0,
                    'b' => 1
                ),
                "Expected player 2 to be victorious"
            ),
            
        );
    }
    
/**
 * 
 * @param array $input
 * @param type $expected
 * @param type $message
 * 
 * @dataProvider getScoreProvider
 */
    public function testGetScore($input, $expected, $message) {
        $result = $this->Match->getScore($input);
        
        $this->assertEqual($expected, $result, $message);
    }

}

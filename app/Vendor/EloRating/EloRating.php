<?php
/**
 * This class calculates ratings based on the Elo system used in chess.
 *
 * @author Priyesh Patel <priyesh@pexat.com> & David Yell <neon1024@gmail.com>
 * @copyright Copyright (c) 2011 onwards, Priyesh Patel
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License
 */
class Rating {
    
/**
 * The factor determining how far and how fast people move around in the ratings
 * Learn more about what this does, 
 * http://en.wikipedia.org/wiki/Elo_rating_system#Most_accurate_K-factor
 * 
 * @var int The K Factor used.
 * 
 */
    const KFACTOR = 24;

/**
 * Storage for the various calculated values
 * 
 * @var int 
 */
    public $ratingA;

    public $ratingB;

    public $scoreA;

    public $scoreB;

    public $expectedA;

    public $expectedB;

    public $newRatingA;

    public $newRatingB;

/**
 * Costructor function which does all the maths and stores the results ready
 * for retrieval.
 *
 * @param int Current rating of A
 * @param int Current rating of B
 * @param int Score of A
 * @param int Score of B
 */
    public function __construct($ratingA, $ratingB, $scoreA, $scoreB) {
        $this->ratingA = $ratingA;
        $this->ratingB = $ratingB;
        $this->scoreA = $scoreA;
        $this->scoreB = $scoreB;

        $expectedScores = $this->getExpectedScores($this->ratingA, $this->ratingB);
        $this->expectedA = $expectedScores['a'];
        $this->expectedB = $expectedScores['b'];

        $newRatings = $this->getNewRatings($this->ratingA, $this->ratingB, $this->expectedA, $this->expectedB, $this->scoreA, $this->scoreB);
        $this->newRatingA = $newRatings['a'];
        $this->newRatingB = $newRatings['b'];
    }

/**
 * Calculate the expected scores between two players
 * 
 * @param int $ratingA
 * @param int $ratingB
 * @return array
 */
    public function getExpectedScores($ratingA, $ratingB) {
        $expectedScoreA = 1 / (1 + ( pow(10, ($ratingB - $ratingA) / 400)) );
        $expectedScoreB = 1 / (1 + ( pow(10, ($ratingA - $ratingB) / 400)) );

        return array(
            'a' => $expectedScoreA,
            'b' => $expectedScoreB
        );
    }

/**
 * Calculate the new ratings and return them
 * 
 * @param int $ratingA
 * @param int $ratingB
 * @param int $expectedA
 * @param int $expectedB
 * @param int $scoreA
 * @param int $scoreB
 * @return array
 */
    public function getNewRatings($ratingA, $ratingB, $expectedA, $expectedB, $scoreA, $scoreB) {
        $newRatingA = $ratingA + self::KFACTOR * ( $scoreA - $expectedA );
        $newRatingB = $ratingB + self::KFACTOR * ( $scoreB - $expectedB );

        return array(
            'a' => $newRatingA,
            'b' => $newRatingB
        );
    }

}
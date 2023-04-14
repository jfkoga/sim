<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\HenningAlgorithm;

class HenningAlgorithmTest extends TestCase {

    public function test_create_object_of_type_henningalgorithm_and_do_an_iteration(): void {

        $henning = new HenningAlgorithm();
        $this->assertIsObject($henning);

        // Simulate values read from the database.
        $henning->setVariable('difficultyHigh', [4, 3]);
        $henning->setVariable('difficultyLow', [2, 2]);
        $henning->setVariable('currentDifficulty', 3);
        $henning->setVariable('sumDifficulty', 12);
        $henning->setVariable('length', 4);
        $henning->setVariable('numRight', 3);

        // Simulate last question was right.
        $lastRight = true;

        // Do the action under evaluation.
        $completed = $henning->iteration($lastRight);

        // Assert all the results (partial and final) of the iteration.
        $this->assertFalse($completed);
        $this->assertEquals([4, 4], $henning->getVariable('difficultyHigh'));
        $this->assertEquals([2, 2], $henning->getVariable('difficultyLow'));
        $this->assertEquals(4, $henning->getVariable('nextDifficulty'));
        $this->assertEquals(5, $henning->getVariable('length'));
        $this->assertEquals(4, $henning->getVariable('numRight'));
        $this->assertEquals(16, $henning->getVariable('sumDifficulty'));
        $this->assertEquals(3.2, $henning->getVariable('height'));
        $this->assertEquals(3.3333, round($henning->getVariable('width'), 4));
        $this->assertEquals(0.8, $henning->getVariable('proportion'));
        $this->assertEquals(0.9305, round($henning->getVariable('A'), 4));
        $this->assertEquals(1.0, round($henning->getVariable('B'), 4));
        $this->assertEquals(0.9643, round($henning->getVariable('C'), 4));
        $this->assertEquals(4.128, round($henning->getVariable('ability'), 4));
        $this->assertEquals(0.8312, round($henning->getVariable('error'), 4));
    }

}

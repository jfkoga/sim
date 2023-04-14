<?php

namespace Tests\Feature;

use App\Classes\HenningAlgorithm;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MCQTest extends TestCase {

    use RefreshDatabase;

    public function test_execute_full_mcq_test(): void {

        $cTestLevel = 1;
        $answers = [1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1];

        $user = User::factory(1)->create();

        $session = Session::create([
            'user_id' => $user[0]->id,
            'language' => 2,
            'position' => 1,
        ]);

        end($answers);
        $last_key = key($answers);

        foreach ($answers as $key => $answer) {
            // Number of rows in table henning_algorithm_data.
            $count = DB::table('henning_algorithm_data')
                ->where('session_id', $session->id)
                ->get()
                ->count();

            $henning = new HenningAlgorithm();

            if ($count !== 0) {
                // All the iterations but the first.
                $iteration = DB::table('henning_algorithm_data')
                    ->where('session_id', $session->id)
                    ->orderBy('id', 'desc')
                    ->first();

                $henning->setVariable('difficultyHigh', [$iteration->difficulty_high_high, $iteration->difficulty_high_low]);
                $henning->setVariable('difficultyLow', [$iteration->difficulty_low_high, $iteration->difficulty_low_low]);
                $henning->setVariable('currentDifficulty', $iteration->current_difficulty);
                $henning->setVariable('nextDifficulty', $iteration->next_difficulty);
                $henning->setVariable('sumDifficulty', $iteration->sum_difficulty);
                $henning->setVariable('length', $iteration->length);
                $henning->setVariable('numRight', $iteration->num_right);
                $henning->setVariable('width', $iteration->width);
                $henning->setVariable('proportion', $iteration->proportion);
                $henning->setVariable('A', $iteration->A);
                $henning->setVariable('B', $iteration->B);
                $henning->setVariable('C', $iteration->C);
                $henning->setVariable('ability', $iteration->ability);
                $henning->setVariable('error', $iteration->error);
            } else {
                // First iteration.
                $henning->fillFirstIteration($cTestLevel, (bool)$answer);
            }

            $henning->iteration($answer);

            DB::table('henning_algorithm_data')->insert([
                'session_id' => $session->id,
                'question_sequence' => 1,
                'difficulty_high_high' => $henning->getVariable('difficultyHigh')[0],
                'difficulty_high_low' => $henning->getVariable('difficultyHigh')[1],
                'difficulty_low_high' => $henning->getVariable('difficultyLow')[0],
                'difficulty_low_low' => $henning->getVariable('difficultyLow')[1],
                'current_difficulty' => $henning->getVariable('currentDifficulty'),
                'next_difficulty' => $henning->getVariable('nextDifficulty'),
                'sum_difficulty' => $henning->getVariable('sumDifficulty'),
                'length' => $henning->getVariable('length'),
                'num_right' => $henning->getVariable('numRight'),
                'width' => $henning->getVariable('width'),
                'proportion' => $henning->getVariable('proportion'),
                'A' => $henning->getVariable('A'),
                'B' => $henning->getVariable('B'),
                'C' => $henning->getVariable('C'),
                'ability' => $henning->getVariable('ability'),
                'error' => $henning->getVariable('error'),
            ]);

            if ($key === $last_key) {
                $this->assertEquals([4, 4], $henning->getVariable('difficultyHigh'));
                $this->assertEquals([2, 2], $henning->getVariable('difficultyLow'));
                $this->assertEquals(4, $henning->getVariable('currentDifficulty'));
                $this->assertEquals(4, $henning->getVariable('nextDifficulty'));
                $this->assertEquals(40, $henning->getVariable('sumDifficulty'));
                $this->assertEquals(11, $henning->getVariable('length'));
                $this->assertEquals(10, $henning->getVariable('numRight'));
                $this->assertEquals(3.6364, round($henning->getVariable('height'), 4));
                $this->assertEquals(2.4444, round($henning->getVariable('width'), 4));
                $this->assertEquals(0.9091, round($henning->getVariable('proportion'), 4));
                $this->assertEquals(0.8916, round($henning->getVariable('A'), 4));
                $this->assertEquals(0.9997, round($henning->getVariable('B'), 4));
                $this->assertEquals(0.9132, round($henning->getVariable('C'), 4));
                $this->assertEquals(4.5219, round($henning->getVariable('ability'), 4));
                $this->assertEquals(0.4771, round($henning->getVariable('error'), 4));
            }

            unset($henning);

        }
    }

}

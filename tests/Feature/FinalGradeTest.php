<?php

namespace Tests\Feature;

use App\Classes\FinalGrade;
use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FinalGradeTest extends TestCase {

    use RefreshDatabase;

    public function test_calculate_final_grade(): void {

        $user = User::factory(1)->create();

        $session = Session::create([
            'user_id' => $user[0]->id,
            'language' => 2,
            'position' => 1,
        ]);

        DB::table('ctest_results')
            ->insert([
                'session_id' => $session->id,
                'ctest_points' => 90,
                'ctest_level' => 4,
            ]);

        DB::table('mcq_results')
            ->insert([
                'session_id' => $session->id,
                'henning_level' => 3.6809,
                'mcq_level' => 4,
            ]);

        $grade = new FinalGrade();
        $grade->loadSessionResults($session->id);
        $finalGrade = $grade->calculateFinalGrade();

        $this->assertEquals(11, $finalGrade);
        $this->assertEquals('S2', $grade->convertGrade($finalGrade));

    }

}

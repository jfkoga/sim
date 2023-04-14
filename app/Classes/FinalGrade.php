<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class FinalGrade {

    private const CTESTTHRESHOLD1 = 67;
    private const CTESTTHRESHOLD2 = 76;
    private const CTESTTHRESHOLD3 = 80;
    private const CTESTMINPOINTS = 0;
    private const CTESTMAXPOINTS = 100;
    private const CTESTEXCELLENT = 97;
    private const HENNINGEXCELLENT = 4.3;

    private int $sessionId;
    private int $ctestPoints = 0;
    private int $ctestLevel = 0;
    private float $henningLevel = 0;

    /**
     * Loads the results of CTest and MCQ from database into the object's attributes.
     *
     * @param int $sessionId
     * @return bool
     */
    public function loadSessionResults(int $sessionId): bool {
        $results = DB::table('ctest_results')
            ->where('session_id', $sessionId)
            ->orderBy('id', 'desc')
            ->first();

        if (!empty($results)) {
            $this->sessionId = $sessionId;
            $this->ctestPoints = $results->ctest_points;
        } else {
            return false;
        }

        $results = DB::table('mcq_results')
            ->where('session_id', $sessionId)
            ->orderBy('id', 'desc')
            ->first();

        if (!empty($results)) {
            $this->henningLevel = $results->henning_level;
        } else {
            return false;
        }

        return true;
    }

    /**
     * Calculates the CTest level. Loads the CTest points from database, does the calculations and saves the result
     * back to database.
     *
     * @return bool
     */
    private function calculateCtestResult(): bool {
        if (!is_numeric($this->ctestPoints) &&
            ($this->ctestPoints >= self::CTESTMINPOINTS)
            ($this->ctestPoints <= self::CTESTMAXPOINTS)) {
            return false;
        }

        if ($this->ctestPoints <= self::CTESTTHRESHOLD1) {
            $this->ctestLevel = 1;
        } elseif ($this->ctestPoints <= self::CTESTTHRESHOLD2) {
            $this->ctestLevel = 2;
        } elseif ($this->ctestPoints <= self::CTESTTHRESHOLD3) {
            $this->ctestLevel = 3;
        } else {
            $this->ctestLevel = 4;
        }

        DB::table('ctest_results')
            ->where('session_id', $this->sessionId)
            ->update([
                'ctest_level' => $this->ctestLevel,
            ]);

        return true;
    }

    /**
     * Calculates the final grade of the whole test. Uses the CTest level and implements the conditions to get a number
     * between 1 and 13.
     *
     * @return int
     */
    public function calculateFinalGrade(): int {
        if (!$this->calculateCtestResult()) {
            return -1;
        }

        $conversion = [
            1 => [0.5, 1],
            2 => [1.6, 2],
            3 => [2.6, 3],
            4 => [3.6, 4],
        ];

        // At this point, $this->ctestLevel should have a value in: 1, 2, 3, 4.

        foreach ($conversion as $key => $value) {
            [$lowThreshold, $highThreshold] = $value;

            if ($this->ctestLevel === $key) {
                if ($this->henningLevel <= $lowThreshold) {
                    $finalGrade = 1;
                } elseif ($this->henningLevel > $highThreshold) {
                    $finalGrade = 3;
                } else {
                    $finalGrade = 2;
                }

                // Add offset to get a value from 1 to 12.
                $finalGrade += 3 * ($key - 1);

                break;
            }
        }

        // Special case: excellent users.
        if ($this->henningLevel > self::HENNINGEXCELLENT && $this->ctestLevel <= self::CTESTEXCELLENT) {
            $finalGrade = 12;
        }

        if ($this->henningLevel > self::HENNINGEXCELLENT && $this->ctestLevel > self::CTESTEXCELLENT) {
            $finalGrade = 13;
        }

        return $finalGrade;
    }

    /**
     * Gets the name of the course corresponding to the grade.
     *
     * @param int $grade
     * @return string
     */
    public function convertGrade(int $grade): string {
        $grades = [
            1 => 'B1',
            2 => 'B2',
            3 => 'B3',
            4 => 'E1',
            5 => 'E2',
            6 => 'E3',
            7 => 'I1',
            8 => 'I2',
            9 => 'I3',
            10 => 'S1',
            11 => 'S2',
            12 => 'S3',
            13 => 'S4',
        ];

        return $grades[$grade];
    }

}

<?php

namespace App\Classes;

class HenningAlgorithm {

    private const NUMQUESTIONSMAXLEVEL = 6;
    private const NUMLEVELS = 4;

    private array $difficultyHigh = [0, 0];
    private array $difficultyLow = [0, 0];
    private int $currentDifficulty = 0;
    private int $nextDifficulty = 0;
    private int $sumDifficulty = 0;
    private int $length = 0;
    private int $numRight = 0;
    private float $height = 0.0;
    private float $width = 0.0;
    private float $proportion = 0.0;
    private float $A = 0.0;
    private float $B = 0.0;
    private float $C = 0.0;
    private float $ability = 0.0;
    private float $error = 0.5;

    public function iteration(bool $lastRight): bool {

        // Check for users who respond everything right. This case breaks the algorithm.
        if (($this->length === self::NUMQUESTIONSMAXLEVEL) && ($this->error === 0.0)) {
            return true;
        }

        if ($lastRight) {
            $this->numRight++;
        }

        // Determine the difficulty of the next question.
        $this->updateDifficulty($lastRight);

        // Update, if necessary, the highest and lowest difficulties according to the current question.
        $this->updateHighestDifficulties();
        $this->updateLowestDifficulties();

        // Update the number of questions answered.
        $this->length++;

        // Calculate all the intermediate and final results.
        $this->calculateHeight();
        $this->calculateWidth();
        $this->calculateRatio();
        $this->calculateAbility();
        $this->calculateError();

        // In the following iteration, the "current difficulty" would be the current "next difficulty".
        $this->currentDifficulty = $this->nextDifficulty;

        // The error between the margins means this was the last iteration.
        return $this->error > 0.0 && $this->error < 0.501;

    }

    private function updateDifficulty(bool $lastRight): void {
        if ($lastRight) {
            $this->nextDifficulty = $this->currentDifficulty + 1;
            if ($this->nextDifficulty > self::NUMLEVELS) {
                $this->nextDifficulty = self::NUMLEVELS;
            }
        } else {
            $this->nextDifficulty = $this->currentDifficulty - 1;
            if ($this->nextDifficulty < 1) {
                $this->nextDifficulty = 1;
            }
        }
    }

    private function updateHighestDifficulties(): void {
        if ($this->length === 0) {
            $this->difficultyHigh = [$this->nextDifficulty, $this->nextDifficulty];
        } else if ($this->nextDifficulty > $this->difficultyHigh[0]) {
            $this->difficultyHigh[0] = $this->nextDifficulty;
        } else if ($this->nextDifficulty > $this->difficultyHigh[1]) {
            $this->difficultyHigh[1] = $this->nextDifficulty;
        }
    }

    private function updateLowestDifficulties(): void {
        if ($this->length === 0) {
            $this->difficultyLow = [$this->nextDifficulty, $this->nextDifficulty];
        } else if ($this->nextDifficulty < $this->difficultyLow[0]) {
            $this->difficultyLow[0] = $this->nextDifficulty;
        } else if ($this->nextDifficulty < $this->difficultyLow[1]) {
            $this->difficultyLow[1] = $this->nextDifficulty;
        }
    }

    private function calculateHeight(): void {
        // Increase the accumulated difficulty to include the difficulty of a possible future question.
        $this->sumDifficulty += $this->nextDifficulty;
        $this->height = ($this->length === 0) ? 0.0 : $this->sumDifficulty / $this->length;
    }

    private function calculateWidth(): void {
        if ($this->length !== 2) {
            $this->width =
                (($this->difficultyHigh[0] + $this->difficultyHigh[1] - $this->difficultyLow[1] - $this->difficultyLow[0]) / 2)
                * ($this->length / ($this->length - 2));
        } else {
            $this->width = 0.0;
        }
    }

    private function calculateRatio(): void {
        $this->proportion = $this->numRight / $this->length;
        $this->A = 1 - exp(-$this->width * $this->proportion);
        $this->B = 1 - exp(-$this->width * ($this->width + $this->proportion));
        $this->C = 1 - exp(-$this->width);
    }

    private function calculateAbility(): void {
        if ($this->A === 0.0 || $this->B === 0.0) {
            $this->ability = $this->nextDifficulty;
        } else {
            $this->ability = $this->height + $this->width * ($this->proportion - 0.5) + log($this->A / $this->B);
        }
    }

    private function calculateError(): void {
        if ($this->A === 0.0 || $this->B === 0.0) {
            $this->error = 0.0;
        } else {
            $this->error = sqrt(($this->width * $this->C) / ($this->length * $this->A * $this->B));
        }
    }

    public function getVariable(string $variable): mixed {
        return $this->$variable ?? false;
    }

    public function setVariable(string $variable = '', mixed $value = ''): bool {
        if (!empty($variable) && !empty($value) && isset($this->$variable)) {
            $this->$variable = $value;
            return true;
        }
        return false;
    }

    public function getVariables(): array {
        return [
            'difficultyHigh' => $this->difficultyHigh,
            'difficultyLow' => $this->difficultyLow,
            'currentDifficulty' => $this->currentDifficulty,
            'nextDifficulty' => $this->nextDifficulty,
            'sumDifficulty' => $this->sumDifficulty,
            'length' => $this->length,
            'numRight' => $this->numRight,
            'height' => $this->height,
            'width' => $this->width,
            'proportion' => $this->proportion,
            'A' => $this->A,
            'B' => $this->B,
            'C' => $this->C,
            'ability' => $this->ability,
            'error' => $this->error,
        ];
    }

    public function fillFirstIteration(int $cTestLevel, bool $lastRight): void {
        $initLevel = ($lastRight) ? $cTestLevel + 1 : $cTestLevel;

        $this->currentDifficulty = $cTestLevel;
        $this->difficultyHigh = [$initLevel, $initLevel];
        $this->difficultyLow = [$initLevel, $initLevel];
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MCQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Difficulty 1 -------------------------------------------------------
        DB::table('mcqs')->insert([
            'phrase' => "A: Estàs segur que demà tenim l'examen de matemàtiques?<br>B: ________! Ho sé del cert.<br>",
            'A' => "No tant",
            'B' => "I tant",
            'C' => "Per tant",
            'D' => "Ho crec",
            'SOL' => "B",
            'level' => 1,
            'idType' => 200,
            'idItemType' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "Per poder anar al gimnàs, primer s'ha de fer ________.<br>",
            'A' => "la quota",
            'B' => "la inscripció",
            'C' => "l'imprès",
            'D' => "el formulari",
            'SOL' => "B",
            'level' => 1,
            'idType' => 200,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "Jo, si ________ de tu, no deixaria les classes d'anglès perquè et poden ser molt útils per trobar feina.<br>",
            'A' => "fos",
            'B' => "sóc",
            'C' => "sigui",
            'D' => "era",
            'SOL' => "B",
            'level' => 1,
            'idType' => 200,
            'idItemType' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('mcqs')->insert([
                'phrase' => fake()->sentence(),
                'A' => fake()->word(),
                'B' => fake()->word(),
                'C' => fake()->word(),
                'D' => fake()->word(),
                'SOL' => fake()->randomElement(['A', 'B', 'C', 'D']),
                'level' => 1,
                'idType' => 200,
                'idItemType' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Difficulty 2 -------------------------------------------------------
        DB::table('mcqs')->insert([
            'phrase' => "A: Aquest matí he relliscat i he caigut per les escales de l'escola.<br>B: ________!<br>",
            'A' => "Fa mal",
            'B' => "Oi que sí",
            'C' => "Quin mal",
            'D' => "Malament",
            'SOL' => "C",
            'level' => 2,
            'idType' => 546640,
            'idItemType' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "No sé si té prou sal aquesta escudella. La pots ________? <br><br>",
            'A' => "estimar",
            'B' => "provar",
            'C' => "tastar",
            'D' => "agradar",
            'SOL' => "C",
            'level' => 2,
            'idType' => 200,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "El meu pis no és gens cèntric, és ________ de la ciutat.<br>",
            'A' => "A la rodalia",
            'B' => "Al voltant",
            'C' => "Als afores",
            'D' => "A la vora",
            'SOL' => "C",
            'level' => 2,
            'idType' => 546640,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('mcqs')->insert([
                'phrase' => fake()->sentence(),
                'A' => fake()->word(),
                'B' => fake()->word(),
                'C' => fake()->word(),
                'D' => fake()->word(),
                'SOL' => fake()->randomElement(['A', 'B', 'C', 'D']),
                'level' => 2,
                'idType' => 200,
                'idItemType' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


        // Difficulty 3 -------------------------------------------------------
        DB::table('mcqs')->insert([
            'phrase' => "A: Quines sabates vols? Aquestes?<br>B: No, les de color ________.<br><br>",
            'A' => "blava",
            'B' => "blaus",
            'C' => "blaves",
            'D' => "blau",
            'SOL' => "D",
            'level' => 3,
            'idType' => 200,
            'idItemType' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "A: A mi m'interessa molt el món de l'astrologia.<br>B: Doncs, jo no ________ crec gaire, en tot això.<br>",
            'A' => "hi",
            'B' => "-",
            'C' => "ho",
            'D' => "en",
            'SOL' => "A",
            'level' => 3,
            'idType' => 200,
            'idItemType' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "Alguns economistes van ________ la crisi del petroli fa una dècada.<br>",
            'A' => "predir",
            'B' => "esdevenir",
            'C' => "revocar",
            'D' => "desdir",
            'SOL' => "A",
            'level' => 3,
            'idType' => 200,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('mcqs')->insert([
                'phrase' => fake()->sentence(),
                'A' => fake()->word(),
                'B' => fake()->word(),
                'C' => fake()->word(),
                'D' => fake()->word(),
                'SOL' => fake()->randomElement(['A', 'B', 'C', 'D']),
                'level' => 3,
                'idType' => 200,
                'idItemType' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Difficulty 4 -------------------------------------------------------
        DB::table('mcqs')->insert([
            'phrase' => "Compte no rellisquis! Hi ha tasques de ______ a terra.",
            'A' => "grassa",
            'B' => "greixó",
            'C' => "greix",
            'D' => "gras",
            'SOL' => "C",
            'level' => 4,
            'idType' => 200,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "He portat el cotxe al mecànic perquè li faci una ________ a punt.<br>",
            'A' => "posta",
            'B' => "passada",
            'C' => "presa",
            'D' => "posada",
            'SOL' => "D",
            'level' => 4,
            'idType' => 200,
            'idItemType' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('mcqs')->insert([
            'phrase' => "A: Aquest pastís de xocolata l'he comprat per a vós. ________ agrada la xocolata, oi?<br>B: Sí, m'agrada molt, gràcies.<br>",
            'A' => "Li",
            'B' => "Els",
            'C' => "Us",
            'D' => "T'",
            'SOL' => "C",
            'level' => 4,
            'idType' => 200,
            'idItemType' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('mcqs')->insert([
                'phrase' => fake()->sentence(),
                'A' => fake()->word(),
                'B' => fake()->word(),
                'C' => fake()->word(),
                'D' => fake()->word(),
                'SOL' => fake()->randomElement(['A', 'B', 'C', 'D']),
                'level' => 4,
                'idType' => 200,
                'idItemType' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::create([
            'title' => 'PHP Trainee Program',
            'description' => 'PHP Dev-Ops with Laravel Framework',
            'content' => preg_replace('[\s+]', ' ', 'Lorem ipsum dolor sit amet, ocurreret intellegebat cum et, quaestio
                voluptatum ad est. Errem exerci partem duo eu. Tacimates constituam definitionem ad est, dicta audiam omnesque
                cu est, usu ubique alienum at. Eu his virtute impedit, ne rebum timeam vis, ad eligendi tincidunt vituperatoribus vel.')
        ]);

        Program::create([
            'title' => 'Ruby Trainee Program',
            'description' => 'Ruby Dev-Ops with Rails Framework',
            'content' => preg_replace('[\s+]', ' ', 'Lorem ipsum dolor sit amet, ocurreret intellegebat cum et, quaestio
                voluptatum ad est. Errem exerci partem duo eu. Tacimates constituam definitionem ad est, dicta audiam omnesque
                cu est, usu ubique alienum at. Eu his virtute impedit, ne rebum timeam vis, ad eligendi tincidunt vituperatoribus vel.')
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DadosComplementares>
 */
class DadosComplementaresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'relevancia' => 'Relevante',
            'justificativa' => 'Justificativa',
            'objetivos' => 'Objetivos',
            'resumo' => 'Resumo',
            'referencias' => 'Referencias',
            'solicitacao_id' => 1
        ];
    }
}

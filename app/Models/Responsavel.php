<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'treinamento',
        'vinculo_instituicao',
        'experiencia_previa',
        'termo_responsabilidade',
        'treinamento_file',
        'solicitacao_id',
        'departamento_id',
    ];

    public function colaboradores(){
        return $this->hasMany('App\Models\Colaborador');
    }

    public function contato(){
        return $this->hasOne('App\Models\Contato');
    }

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento');
    }

    public function solicitacao(){
        return $this->belongsTo('App\Models\Solicitacao');
    }

    public function avaliacao_individual(){
        return $this->hasOne('App\Models\AvaliacaoIndividual');
    }
}

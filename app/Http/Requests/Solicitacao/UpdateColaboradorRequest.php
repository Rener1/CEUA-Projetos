<?php

namespace App\Http\Requests\Solicitacao;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateColaboradorRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }
    public function rules()
    {
        return [
            'solicitacao_id' => 'required|integer',
            'colab_nome' => 'required|string',
            'colab_telefone' => [
                'required',
                'regex:/^\(\d{2}\) \d{4,5}\-\d{4}$/',
            ],
            'colab_cpf' => [
                'required',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            ],
            'colab_instituicao_id' => 'required',
            'colab_grau_escolaridade' => 'required|string',
            'colab_opcao_experiencia_previa' => 'in:on,off',
            'colab_experiencia_previa' => 'required_if:colab_opcao_experiencia_previa,on|mimes:pdf',
            'colab_opcao_termo_responsabilidade' => 'in:on,off',
            'colab_termo_responsabilidade' => 'required_if:opcao_termo_responsabilidade,on|mimes:pdf',
            'colab_treinamento' => 'required_if:opcao_treinamento,on|min:3|max:1000',
            'colab_treinamento_file' => 'required_if:colab_treinamento_radio,on|mimes:pdf',
            'colab_email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'colab_nome.required' => 'O nome é obrigatório.',
            'colab_cpf.required' => 'O CPF é obrigatório.',
            'colab_instituicao_id.required' => 'A instituição é obrigatória.',
            'colab_grau_escolaridade.required' => 'O grau de escolaridade é obrigatório.',
            'colab_experiencia_previa.required_if' => 'A experiência prévia é obrigatória caso a opção sim esteja marcada.',
            'mimes:pdf' => 'O :attribute deve ser um PDF',
            'colab_treinamento.required_if' => 'O campo treinamento é obrigatório caso a opção sim esteja marcada.',
            'colab_treinamento_file.required_if' => 'O arquivo de treinamento é obrigatório caso a opção sim esteja marcada.',
            'colab_email.required' => 'O email é obrigatório.',
            'colab_email.email' => 'O email deve ser um endereço de e-mail válido.',
            'colab_telefone.required' => 'O telefone é obrigatório.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('falhaValidacao', false);
        session()->flash('colaborador', $this->input('colaborador_id'));

        parent::failedValidation($validator);
    }
}

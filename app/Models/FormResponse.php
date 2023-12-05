<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormResponse extends Model
{
    use HasFactory, CascadeSoftDeletes;


    protected $fillable = [
        'form_id', 'response_code', 'respondent_ip', 'respondent_user_agent'
    ];

    protected array $cascadeDeletes = ['fieldResponses'];

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function fieldResponses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FieldResponse::class);
    }

    public function generateResponseCode(): void
    {
        do {
            $this->response_code = Str::random(64);
        } while (static::where('response_code', $this->response_code)->exists());
    }

    public function getQuestionAnswerMap(): array
    {
        $this->loadMissing('fieldResponses.formField');

        $map = [];

        foreach ($this->fieldResponses as $response) {
            $field = $response->formField;
            $data = [];

            if (!$field) {
                continue;
            }

            $data = [
                'question' => $field->question,
                'answer' => $response->getAnswerForTemplate($field->template),
                'required' => $field->required,
                'template' => $field->template,
                'options' => $field->options,
            ];

            array_push($map, $data);
        }

        return $map;
    }
}

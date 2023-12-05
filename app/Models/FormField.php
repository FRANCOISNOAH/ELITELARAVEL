<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use HasFactory,SoftDeletes, CascadeSoftDeletes;


    protected $fillable = [
        'form_id', 'template', 'question', 'required', 'options', 'attribute', 'filled'
    ];

    protected $casts = [
        'required' => 'boolean',
        'filled' => 'boolean',
        'options' => 'array',
    ];

    protected array $cascadeDeletes = ['responses'];

    public function scopeFilled($query)
    {
        return $query->where('filled', true);
    }

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function responses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FieldResponse::class);
    }

    public function getResponseSummaryDataForChart(): array
    {
        $responses = $this->responses;

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';

                $data[] = ($this->template == 'drop-down')
                    ? ['Option', 'No. of option selected']
                    : ['Choice', 'No. of choice selected'];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '_', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChart2()
    {
        $responses = $this->responses;

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';

                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '-', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartPays($paysid)
    {
        $responses = $this->responses->where('country_id',$paysid);

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '_', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartPays2($paysid)
    {
        $responses = $this->responses->where('country_id',$paysid);

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '-', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartSite($siteid)
    {
        $responses = $this->responses->where('site_id',$siteid);

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '_', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartSite2($siteid)
    {
        $responses = $this->responses->where('site_id',$siteid);

        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '-', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartVille($ville)
    {
        $responses = $this->responses->where('ville','=',$ville);
        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '_', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartVille2($ville)
    {
        $responses = $this->responses->where('ville','=',$ville);
        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '-', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartUser($userid)
    {
        $responses = $this->responses->where('user_id','=',$userid);
        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '_', $this->attribute),
            'data' => $data
        ];
    }

    public function getResponseSummaryDataForChartUser2($userid)
    {
        $responses = $this->responses->where('user_id','=',$userid);
        if ($responses->isEmpty()) {
            return [];
        }

        $use_chart = '';
        $data = [];

        switch ($this->template) {
            case 'drop-down':
            case 'multiple-choices':
            case 'checkboxes':
                $use_chart = ($this->template == 'checkboxes') ? 'h_bar_chart' : 'pie_chart';
                $data[] = ($this->template == 'drop-down')
                    ? ['Option', "N° de l'option sélectionnée'"]
                    : ['Choice', "N° du choix sélectionné"];

                foreach ($this->options as $option) {
                    if ($this->template == 'checkboxes') {
                        $option_selected_count = $responses->filter(function ($v, $k) use ($option) {
                            $value = (array) json_decode($v->answer);
                            return in_array($option, $value);
                        })->count();
                    } else {
                        $option_selected_count = $responses->where('answer', $option)->count();
                    }

                    array_push($data, [$option, $option_selected_count]);
                }

                break;

            case 'linear-scale':
                $use_chart = 'v_bar_chart';
                $min = $this->options['min'];
                $max = $this->options['max'];

                $data[] = ['Scale value', 'Count'];

                foreach (range((int) $min['value'], (int) $max['value']) as $value) {
                    $value_selected_counts = $responses->where('answer', $value)->count();

                    array_push($data, [$value, $value_selected_counts]);
                }

                break;
        }

        return [
            'chart' => $use_chart,
            'name' => str_replace('.', '-', $this->attribute),
            'data' => $data
        ];
    }
}

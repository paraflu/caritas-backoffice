<?php

namespace App\Traits;

use App\Helpers\Icons;
use Illuminate\Database\Eloquent\Model;

trait HasActionColumn
{

    public function buildActionColumns(Model $model, string $routeBase, callable $callback = null, $noinsert = false, $nodelete = false): string
    {
        $html = '<div class="w-full flex justify-end">';
        if (!$noinsert) {
            $html .= '<button class="btn" data-id="' . $model->id . '" data-action="edit" title="' . __($routeBase . '.edit') . '"><div>' . Icons::pencil() . '</div></button>';
        }
        if (!$nodelete) {
            $html .= '<button class="ml-2 btn danger" data-id="' . $model->id . '" data-action="destroy" title="' . __($routeBase . '.delete') . '"><div>' . Icons::trash() . '</div></button>';
        }
        if ($callback) {
            $html .= $callback($model);
        }
        return $html . '</div>';
    }
}

<?php

namespace App\Traits;

use App\Helpers\Icons;
use Illuminate\Database\Eloquent\Model;

trait HasActionColumn
{

    public function buildActionColumns(Model $model, string $routeBase, callable $callback = null): string
    {

        $html = '<div class="w-full flex justify-end"><button class="btn btn-sm p-0" data-id="' . $model->id . '" data-action="edit" title="' . __($routeBase . '.edit') . '"><div>' . Icons::pencil() . '</div></button>'
            . '<button class="ml-2 btn btn-sm p-0 danger" data-id="' . $model->id . '" data-action="destroy" title="' . __($routeBase . '.delete') . '"><div>' . Icons::trash() . '</div></button>'
            ;
        if ($callback) {
            $html .= $callback($model);
        }
        return $html . '</div>';
    }
}

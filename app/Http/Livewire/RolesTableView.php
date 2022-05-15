<?php

namespace App\Http\Livewire;

use App\Actions\ActivateRoleAction;
use LaravelViews\Views\TableView;
use Spatie\Permission\Models\Role;

class RolesTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Role::class;
    protected $paginate = 10;
    public $searchBy = ['name', 'guard_name'];

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            'Role name',
            'Guard name',
            'Created',
            'Updated'
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        return [
            $model->name,
            $model->guard_name,
            $model->created_at,
            $model->updated_at
        ];
    }

    protected function actionsByRow()
    {
        return [
            new ActivateRoleAction,
        ];
    }
}

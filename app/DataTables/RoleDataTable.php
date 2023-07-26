<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('permission', function ($query) {
                $all_permission = '';
                foreach ($query->permissions()->pluck('name') as $permission) {
                    $all_permission .=
                        '<span class="badge rounded p-2 m-1 px-3 bg-primary ">
                                <a href="#" class="text-white">' .
                        $permission .
                        '</a>
                            </span>';
                }
                return $all_permission;
            })
            ->addColumn('action', function ($query) {
                return '
                 <a  href="' . route('roles.edit', $query->id) .'" data-id="'.$query->id.'" class="btn btn-primary btn-sm"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></a>
                <button data-id="'.$query->id.'" class="btn btn-danger btn-sm role-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            })
            ->rawColumns(['permission','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->where('name', '!=' , 'Super Admin')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(Button::make('create'), Button::make('export'), Button::make('print'), Button::make('reset'), Button::make('reload'));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Role_' . date('YmdHis');
    }
}

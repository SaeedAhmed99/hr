<?php

namespace App\DataTables;

use App\Models\Branch;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BranchDataTable extends DataTable
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
            ->addColumn('action', function ($query) {
                $button = '';

                if (Auth::user()->can('Edit Branch')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_branch_modal" data-id="'.$query->id.'" title="Edit" class="btn btn-primary btn-sm branch-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can('Delete Branch')) {
                    $button .= '<button data-id="'.$query->id.'" class="btn btn-danger btn-sm branch-delete" title="Delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
            // ->addColumn('action', function ($query) {
            //     return '
            //     <button data-bs-toggle="modal" data-bs-target="#edit_branch_modal" data-id="'.$query->id.'" title="Edit" class="btn btn-primary btn-sm branch-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>
            //     <button data-id="'.$query->id.'" class="btn btn-danger btn-sm branch-delete" title="Delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            // });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Branch $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Branch $model)
    {
        return $model->orderBy('order', 'ASC')->orderBy('created_at', 'ASC')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('branch-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
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
        return 'Branch_' . date('YmdHis');
    }
}

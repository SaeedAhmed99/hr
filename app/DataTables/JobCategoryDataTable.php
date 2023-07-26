<?php

namespace App\DataTables;

use App\Models\JobCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JobCategoryDataTable extends DataTable
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
                return '
                <button data-bs-toggle="modal" data-bs-target="#edit_jobCategory_modal" data-id="'.$query->id.'" class="btn btn-primary btn-sm jobCategory-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>
                <button data-id="'.$query->id.'" class="btn btn-danger btn-sm jobCategory-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\JobCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JobCategory $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('jobcategory-table')
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
        return 'JobCategory_' . date('YmdHis');
    }
}

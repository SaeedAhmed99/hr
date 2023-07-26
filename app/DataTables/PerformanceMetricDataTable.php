<?php

namespace App\DataTables;

use App\Models\PerformanceMetric;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PerformanceMetricDataTable extends DataTable
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
                $button = "";
                if(Auth::user()->can("Update Performance Metric")){
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_performancemetric_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm performancemetric-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can("Delete Performance Metric")) {
                    $button .= '<button data-id="' . $query->id . '" class="m-1 btn btn-danger btn-sm performancemetric-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PerformanceMetric $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PerformanceMetric $model)
    {
        return $model->with('performanceCriterion')->select('performance_metrics.*')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('performancemetric-table')
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
        return 'PerformanceMetric_' . date('YmdHis');
    }
}

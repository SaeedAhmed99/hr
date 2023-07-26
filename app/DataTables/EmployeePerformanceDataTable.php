<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Models\EmployeePerformance;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeePerformanceDataTable extends DataTable
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
            ->addColumn('performance_month', function ($query) {
                return '' . date('M Y', strtotime($query->performance_month)) . '';
            })
            ->addColumn('score_avarage', function ($query) {
                $rating = "";
                for ($i = 1; $i <= 5; $i++) {
                    if ($query->score_avarage < $i) {
                        if (is_float($query->score_avarage) && round($query->score_avarage) == $i) {
                            $rating .= '<i class="text-warning fas fa-star-half-alt"></i>';
                        } else {
                            $rating .= '<i class="fas fa-star"></i>';
                        }
                    } else {
                        $rating .= '<i class="text-warning fas fa-star"></i>';
                    }
                }
                return $rating . "(".$query->score_avarage.")";
            })
            ->addColumn('action', function ($query) {
                $button = '';
                if (Auth::user()->can('Show Performance')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#show_performance_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm performance-show"><i class="fa-solid fa-eye"></i></button>';
                }
                if (Auth::user()->can('Edit Performance')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_performance_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm performance-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can('Delete Performance')) {
                    $button .= '<button data-id="' . $query->id . '" class="m-1 btn btn-danger btn-sm performance-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            })
            ->rawColumns(['performance_month', 'score_avarage', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmployeePerformance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmployeePerformance $model)
    {
        if (!Auth::user()->hasRole('Super Admin') && Auth::user()->can('Show Performance')) {
            return $model
                ->with('employee.user', 'branch', 'designation', 'performed_user')
                ->where('employee_performances.employee_id', Auth::user()->employee->id)
                ->select('employee_performances.*')
                ->newQuery();
        } else {
            return $model
                ->with('employee.user', 'branch', 'designation', 'performed_user')
                ->select('employee_performances.*')
                ->newQuery();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employeeperformance-table')
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
        return 'EmployeePerformance_' . date('YmdHis');
    }
}

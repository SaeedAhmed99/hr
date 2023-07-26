<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Models\LeaveType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeLeaveDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $total_leave_days = LeaveType::sum('days');
        return datatables()
            ->eloquent($query)
            ->addColumn('approved', function ($query) {
                return $query->leaveApplied->where('status', 1)->sum('total_leave_days');
            })
            ->addColumn('totalLeave', function ($query) use ($total_leave_days) {
                return $total_leave_days;
            })
            ->addColumn('leaveRemaining', function ($query) use ($total_leave_days) {
                return ($total_leave_days - $query->leaveApplied->where('status', 1)->sum('total_leave_days'));
            })
            ->addColumn('action', function ($query) {
                return '<button data-id="' . $query->id . '" class="btn btn-info btn-xs detailed-report"><i title="Detailed report" class="fas fa-eye"></i></button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Employee $model)
    {
        $year = $this->year;
        return $model->with('user')->with([
            'leaveApplied' => function ($query) use ($year) {
                $query->whereYear('start_date', $year);
            }
        ])->select('employees.*')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employeeleave-table')
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
        return 'EmployeeLeave_' . date('YmdHis');
    }
}

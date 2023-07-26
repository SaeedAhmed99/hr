<?php

namespace App\DataTables;

use App\Models\Employee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
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
            ->addColumn('employee_id', function ($query) {
                $prefix = '#EMP00';
                return '' . $prefix . sprintf('%05d', $query->employee_id) . '';
            })
            ->addColumn('user.name', function (Employee $employee) {
                return $employee->user ? $employee->user->name : '-';
            })
            ->addColumn('user.email', function (Employee $employee) {
                return $employee->user ? $employee->user->email : '-';
            })
            ->addColumn('branch', function (Employee $employee) {
                return $employee->branch ? $employee->branch->name : '-';
            })
            ->addColumn('department', function (Employee $employee) {
                return $employee->department ? $employee->department->name : '-';
            })
            ->addColumn('designation', function (Employee $employee) {
                return $employee->designation ? $employee->designation->name : '-';
            })
            ->addColumn('role', function ($query) {
                return $query->user->roles->first() ? $query->user->roles->first()->name : "";
            })
            ->addColumn('action', function ($query) {
                $button = '<a class="btn btn-info btn-sm" href="' . route('user.profile', $query->user->id) . '"><i class="fas fa-eye"></i></a>';

                if (Auth::user()->can('Edit Employee')) {
                    $button .= '<a  href="' . route('employee.edit', $query->id) . '" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></a>';
                }
                if (Auth::user()->can('Delete Employee')) {
                    $button .= '<button data-id="' . $query->id . '" class="btn btn-danger btn-sm employees-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
        //    ->addColumn('action', function ($query) {
        //         return '
        //         <a  href="' . route('employee.edit', $query->id) .'" data-id="'.$query->id.'" class="btn btn-primary btn-sm"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></a>
        //         <button data-id="'.$query->id.'" class="btn btn-danger btn-sm employees-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
        //     });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Employee $model)
    {
        return $model->with('user', 'designation', 'branch', 'department')->where('status', 1)->select('employees.*')->newQuery();
        //return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employee-table')
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
        return 'Employee_' . date('YmdHis');
    }
}

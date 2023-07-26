<?php

namespace App\DataTables;

use App\Models\SalarySlip;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SalarySlipDataTable extends DataTable
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
            ->editColumn('employee.salary_receive_type', function ($query) {
                return $query->employee->salary_receive_type == 0 ? "Cash" : "Bank";
            })
            ->editColumn('salary_month', function ($query) {
                return $query->salary_month->format("Y, F");
            })            
            ->editColumn('commission', function ($query) {
                $commissions = json_decode($query->commission);
                $total = 0;
                foreach ($commissions as $commission) {
                    if ($commission->type == 0) {
                        $total += $commission->amount;
                    } else {
                        $total += (($query->basic_salary * $commission->amount) / 100);
                    }
                }
                return $total;
            })
            ->editColumn('allowance', function ($query) {
                $allowances = json_decode($query->allowance);
                $total = 0;
                foreach ($allowances as $allowance) {
                    if ($allowance->type == 0) {
                        $total += $allowance->amount;
                    } else {
                        $total += (($query->basic_salary * $allowance->amount) / 100);
                    }
                }
                return $total;
            })
            ->editColumn('deduction', function ($query) {
                $deductions = json_decode($query->deduction);
                $total = 0;
                foreach ($deductions as $deduction) {
                    if ($deduction->type == 0) {
                        $total += $deduction->amount;
                    } else {
                        $total += (($query->basic_salary * $deduction->amount) / 100);
                    }
                }
                return $total;
            })
            ->editColumn('loan', function ($query) {
                $loans = json_decode($query->loan);
                $total = 0;
                foreach ($loans as $loan) {
                    $total += $loan->installment_amount;
                }
                return $total;
            })
            ->addColumn('employee_id', function ($query) {
                $prefix = '#EMP00';
                return '' . $prefix . sprintf('%05d', $query->employee_id) . '';
            })
            ->addColumn('action', function ($query) {
                return '<button id="'.$query->id.'" data-id="'.$query->id.'" class="text-nowrap btn btn-info btn-xs show-payslip" title="Show payslip">Payslip <i class="fa-solid fa-file-invoice-dollar"></i></button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SalarySlip $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(SalarySlip $model)
    {
        if (Auth::user()->can('Manage Generate Salary')){
            return $model->with(['employee.user', 'employee.designation'])->select("salary_slips.*")->where('salary_month', $this->year . "-" . sprintf("%02d", $this->month) . "-01")->newQuery();
        }else{
            return $model->with(['employee.user', 'employee.designation'])->select("salary_slips.*")->where('salary_month', $this->year . "-" . sprintf("%02d", $this->month) . "-01")->where("salary_slips.employee_id", auth()->user()->employee->id)->newQuery();
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
            ->setTableId('salaryslip-table')
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
        return 'SalarySlip_' . date('YmdHis');
    }
}

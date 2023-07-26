<?php

namespace App\DataTables;

use App\Models\Loan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LoanDataTable extends DataTable
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
            ->editColumn('employee.id', function($query){
                $prefix = '#EMP';
                return '' . $prefix . sprintf('%05d', $query->employee_id) . '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Loan $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Loan $model)
    {
        if(Auth::user()->can("Manage Loan")){
            return $model->select('loans.*')->with(['employee.user', 'loanType'])->newQuery();
        }else if(Auth::user()->can("Show Loan")){
            return $model->select('loans.*')->with(['employee.user', 'loanType'])->where('loans.employee_id', auth()->id())->newQuery();
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
                    ->setTableId('loan-table')
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
        return 'Loan_' . date('YmdHis');
    }
}

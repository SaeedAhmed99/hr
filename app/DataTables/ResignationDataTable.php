<?php

namespace App\DataTables;

use App\Models\Resignation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ResignationDataTable extends DataTable
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
            ->addColumn('notice_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->notice_date)) . '';
            })
            ->addColumn('resignation_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->resignation_date)) . '';
            })
            ->addColumn('action', function ($query) {
                return '
                <button data-bs-toggle="modal" data-bs-target="#edit_resignation_modal" data-id="' .
                    $query->id .
                    '" class="btn btn-primary btn-sm resignation-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>
                <button data-id="' .
                    $query->id .
                    '" class="btn btn-danger btn-sm resignation-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resignation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resignation $model)
    {
        if(Auth::user()->can('Manage Resignation')){
            return $model->with('employee.user')->select('resignations.*')->newQuery();
        }elseif(Auth::user()->can('Show Resignation')){
           return $model->with('employee.user')->where('resignations.employee_id',Auth::user()->employee->id)->select('resignations.*')->newQuery();
            //return $model->with('employee.user','leaveType')->where('leaves.employee_id',Auth::user()->employee->id)->select('leaves.*')->newQuery();
        }else{

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
                    ->setTableId('resignation-table')
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
        return 'Resignation_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Transfer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransferDataTable extends DataTable
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
            ->addColumn('transfer_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->transfer_date)) . '';
            })
            ->addColumn('action', function ($query) {
                $button = "";
                if(Auth::user()->can("Edit Transfer")){
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_transfer_modal" data-id="' .$query->id .'" class="m-1 btn btn-primary btn-sm transfer-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can("Delete Transfer")) {
                    $button .= ' <button data-id="' .$query->id .'" class="btn btn-danger btn-sm transfer-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transfer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transfer $model)
    {

        if(Auth::user()->can('Manage Transfer')){
            return $model->with('branch', 'department', 'employee.user')->select('transfers.*')->newQuery();
        }elseif(Auth::user()->can('Show Transfer')){
            return $model->with('branch', 'department', 'employee.user')->where('transfers.employee_id',Auth::user()->employee->id)->select('transfers.*')->newQuery();
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
            ->setTableId('transfer-table')
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
        return 'Transfer_' . date('YmdHis');
    }
}

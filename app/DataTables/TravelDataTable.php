<?php

namespace App\DataTables;

use App\Models\Travel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TravelDataTable extends DataTable
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
            ->addColumn('start_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->start_date)) . '';
            })
            ->addColumn('end_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->end_date)) . '';
            })

            ->addColumn('action', function ($query) {
                $button = "";
                if(Auth::user()->can("Edit Travel")){
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_travel_modal" data-id="' .
                    $query->id .
                    '" class="m-1 btn btn-primary btn-sm travel-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can("Delete Travel")) {
                    $button .= '<button data-id="' .
                    $query->id .
                    '" class="btn btn-danger btn-sm travel-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Travel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Travel $model)
    {
        if(Auth::user()->can('Manage Travel')){
             return $model->with('employee.user')->select('travels.*')->newQuery();
        }elseif(Auth::user()->can('Show Travel')){
          return $model->with('employee.user')->where('travels.employee_id',Auth::user()->employee->id)->select('travels.*')->newQuery();
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
                    ->setTableId('travel-table')
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
        return 'Travel_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Training;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TrainingDataTable extends DataTable
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
            ->addColumn('duration', function ($query) {
                return ''.$query->start_date.' to '.$query->end_date.'';
            })
             ->addColumn('action', function ($query) {
                $button = "";
                if(Auth::user()->can("Show Training")){
                    $button .= '<a type="button" href="'.route('training.show',$query->id).'"  class="m-1 btn btn-success btn-sm " ><i class="fa-solid fa-eye"></i></a>';
                }
                if(Auth::user()->can("Edit Training")){
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_training_modal" data-id="'.$query->id.'" class="m-1 btn btn-primary btn-sm training-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can("Delete Training")) {
                    $button .= '<button data-id="'.$query->id.'" class="m-1 btn btn-danger btn-sm training-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
            //  ->addColumn('action', function ($query) {
            //     return '
            //     <a type="button" href="'.route('training.show',$query->id).'"  class="btn btn-success btn-sm " ><i class="fa-solid fa-eye"></i> Show</a>
            //     <button data-bs-toggle="modal" data-bs-target="#edit_training_modal" data-id="'.$query->id.'" class="btn btn-primary btn-sm training-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>
            //     <button data-id="'.$query->id.'" class="btn btn-danger btn-sm training-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            // });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Training $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Training $model)

    {
        if(Auth::user()->can('Manage Training')){
           return $model->with('branch', 'traningtype', 'employee.user', 'trainer')->select('trainings.*')->newQuery();
        }elseif(Auth::user()->can('Show Training')){
            return $model->with('branch', 'traningtype', 'employee.user', 'trainer')->where('trainings.employee_id',Auth::user()->employee->id)->select('trainings.*')->newQuery();
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
                    ->setTableId('training-table')
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
        return 'Training_' . date('YmdHis');
    }
}

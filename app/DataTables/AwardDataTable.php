<?php

namespace App\DataTables;

use App\Models\Award;
use App\Models\Employee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AwardDataTable extends DataTable
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
            ->addColumn('date', function ($query) {
                return '' . date('M j, Y', strtotime($query->date)) . '';
            })
            ->addColumn('action', function ($query) {
                $button = '';
                if (Auth::user()->can('Edit Award')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_award_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm award-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can('Delete Award')) {
                    $button .= '<button data-id="' . $query->id . '" class="m-1 btn btn-danger btn-sm award-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            })
            ->rawColumns(['date', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Award $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Award $model)
    {
        if (Auth::user()->can('Manage Award')) {
            return $model
                ->with('awardType', 'employee.user')
                ->select('awards.*')
                ->newQuery();
        } elseif (Auth::user()->can('Show Award')) {
            return $model
                ->with('awardType', 'employee.user')
                ->where('awards.employee_id', Auth::user()->employee->id)
                ->select('awards.*')
                ->newQuery();
        } else {
        }
        // $usr = Auth::user();

        // if (Auth::user()->hrm->type == 'employee') {
        //         $emp = Employee::where('user_id', '=', Auth::user()->id)->first();
        //        return $model->with('awardType','employee.user')->where('employee_id', '=', $emp->id)->get();
        //     } else {
        //        return $model->with('awardType','employee.user')->select('awards.*')->newQuery();
        //     }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('award-table')
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
        return 'Award_' . date('YmdHis');
    }
}

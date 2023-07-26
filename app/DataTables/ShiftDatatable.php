<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Shift;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShiftDatatable extends DataTable
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
            ->addColumn('start_time', function ($query) {
                if (Auth::user()->timezone) {
                    return '' . Carbon::parse($query->start_time)->timezone(Auth::user()->timezone)->format('h:i a') . '';
                } else {
                    return '' . Carbon::parse($query->start_time)->timezone(setting('timezone'))->format('h:i a') . '';
                }
            })
            ->addColumn('end_time', function ($query) {
                if (Auth::user()->timezone) {
                    return '' . Carbon::parse($query->end_time)->timezone(Auth::user()->timezone)->format('h:i a') . '';
                } else {
                    return '' . Carbon::parse($query->end_time)->timezone(setting('timezone'))->format('h:i a') . '';
                }
            })
            ->addColumn('action', function ($query) {
                $button = '';
                if (Auth::user()->can('Edit Award')) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_shift_modal" data-id="' . $query->id . '" class="m-1 btn btn-primary btn-sm shift-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can('Delete Award')) {
                    $button .= '<button data-id="' . $query->id . '" class="m-1 btn btn-danger btn-sm shift-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            })
            ->rawColumns(['start_time', 'end_time', 'action']);
        // return datatables()
        //     ->eloquent($query)
        //     ->addColumn('action', 'shiftdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShiftDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shift $model)
    {
        // return $model->newQuery();
        // if (Auth::user()->can('Manage Award')) {
        return $model
            ->select('shifts.*')
            ->newQuery();
        // } elseif (Auth::user()->can('Show Award')) {
        // return $model
        //     ->with('awardType', 'employee.user')
        //     ->where('awards.employee_id', Auth::user()->employee->id)
        //     ->select('awards.*')
        //     ->newQuery();
        // } else {
        // }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('shiftdatatable-table')
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
        return 'Shift_' . date('YmdHis');
    }
}

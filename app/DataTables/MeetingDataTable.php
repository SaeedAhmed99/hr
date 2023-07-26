<?php

namespace App\DataTables;

use App\Models\Meeting;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MeetingDataTable extends DataTable
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
            ->addColumn('employee_list', function ($query) {
                return view('components.user-badge')->with(['employees' => $query->meeting_employees, 'meeting_id' => $query->id]);
            })
            ->addColumn('time', function ($query) {
                return '' . date("h:i A", strtotime($query->time)) . '';
            })
            ->addColumn('date', function ($query) {
                return '' . date("M j, Y", strtotime($query->date)) . '';
            })
            ->addColumn('action', function ($query) {
                $button = "";
                if (Auth::user()->can("Edit Meeting")) {
                    $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_meeting_modal" data-id="' . $query->id . '" class="btn btn-primary btn-sm meeting-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                }
                if (Auth::user()->can("Delete Meeting")) {
                    $button .= ' <button data-id="' . $query->id . '" class="btn btn-danger btn-sm meeting-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
                }
                return $button;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Meeting $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Meeting $model)
    {
        if (Auth::user()->can('Manage Meeting')) {
            return $model->with('meeting_employees.employee.user')->select('meetings.*')->newQuery();
        } else if (Auth::user()->can('Show Meeting')) {
            return $model->with('meeting_employees.employee.user')->whereHas('meeting_employees', function ($q) {
                // Query the name field in status table
                $q->where('employee_id', auth()->user()->employee->id);
            })->select('meetings.*')->newQuery();
        }
        abort(401);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('meeting-table')
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
        return 'Meeting_' . date('YmdHis');
    }
}

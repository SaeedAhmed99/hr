<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Promotion;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PromotionDataTable extends DataTable
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
            ->addColumn('promotion_date', function ($query) {
                return '' . date('M j, Y', strtotime($query->promotion_date)) . '';
            })
            ->addColumn('action', function ($query) {
                $promotion_date = new Carbon($query->promotion_date);
                if ($promotion_date > now()->startOfDay()) {
                    $button = '';
                    if (Auth::user()->can('Edit Promotion')) {
                        $button .= '<button data-bs-toggle="modal" data-bs-target="#edit_travel_modal" data-id="' . $query->id . '" class="btn btn-primary btn-sm travel-edit"><span class="btn-inner--icon"><i class="fa-regular fa-pen-to-square"></i></span></button>';
                    }
                    return $button;
                }
                // '<button data-id="' . $query->id . '" class="btn btn-danger btn-sm promotion-delete"><span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span></i></button>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Promotion $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Promotion $model)
    {
        if (Auth::user()->can('Manage Promotion')) {
            return $model
                ->with('employee.user', 'old_designation', 'new_designation')
                ->select('promotions.*')
                ->newQuery();
        } elseif (Auth::user()->can('Show Promotion')) {
            return $model
                ->with('employee.user', 'old_designation', 'new_designation')
                ->where('promotions.employee_id', Auth::user()->employee->id)
                ->select('promotions.*')
                ->newQuery();
        } else {
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
            ->setTableId('promotion-table')
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
        return 'Promotion_' . date('YmdHis');
    }
}

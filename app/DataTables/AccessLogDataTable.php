<?php

namespace App\DataTables;

use App\Models\AccessLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccessLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('user', function ($log) {
                return $log->user ? $log->user->name : 'Invitado';
            })
            ->editColumn('updated_at', function (AccessLog $model) {
                return $model->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('login_at', function (AccessLog $model) {
               
                return $model->login_at ? $model->login_at->format('d/m/Y H:i:s') : 'N/A'; 
            })
            ->addColumn('status', function ($log) {
                return ucfirst($log->status); 
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AccessLog $model): QueryBuilder
    {
       
        return $model->newQuery()->with('user'); 
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(['language' => ['url' => '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json']])
            ->setTableId('accesslog-table') 
            ->columns($this->getColumns()) 
            ->minifiedAjax()
            ->orderBy(1) 
            ->selectStyleSingle()
            ->buttons([
                
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('user'), 
            Column::make('status')->title('Status'), 
            Column::make('updated_at')->title('Logeado en'), 
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AccessLog_' . date('YmdHis');
    }
}

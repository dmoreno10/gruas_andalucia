<?php

namespace App\DataTables;

use App\Models\Reservation; // Modelo de reservas
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'reservations.action') // Cambiar a la vista de acciones de reservas
            ->editColumn('created_at', function(Reservation $model) {
                return $model->created_at->format('d/m/Y H:i:s'); // Formato de la fecha
            })
            ->rawColumns(['action']) // Permitir HTML en la columna de acciones
            ->setRowId('id'); // Establecer ID de fila
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Reservation $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'asc'); // Obtener reservas ordenadas por ID
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->columns([
                Column::make('client_name') // Nombre del Cliente
                      ->title('Nombre del Cliente'),
                Column::make('reservation_date') // Fecha de la Reserva
                      ->title('Fecha de Reserva'),
                Column::make('status') // Estado de la Reserva
                      ->title('Estado'),
                Column::make('created_at') // Fecha de Creación
                      ->title('Creado'),
                Column::computed('action') // Columna de acciones
                      ->exportable(false)
                      ->printable(false)
                      ->width(60)
                      ->addClass('text-center'),
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                // Otras configuraciones si son necesarias...
            ]);
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Reservations_' . date('YmdHis');
    }
}

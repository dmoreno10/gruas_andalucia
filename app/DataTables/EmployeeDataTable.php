<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Models\Employees; // Cambiado a Employees
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'employees.action') // Cambiado a la vista de acciones de empleados
            ->editColumn('created_at', function(Employee $model) {
                return $model->created_at->format('d/m/Y H:i:s'); // Formato de la fecha
            })
            ->rawColumns(['action']) // Permitir HTML en la columna de acciones
            ->setRowId('id'); // Establecer ID de fila
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'asc'); // Obtener empleados ordenados por ID
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->columns([
                Column::make('name') // Nombre del Empleado
                      ->title('Nombre'),
                Column::make('email') // Correo del Empleado
                      ->title('Email'),
                Column::make('department') // Departamento del Empleado
                      ->title('Departamento'),
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
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id') // ID del Empleado
                  ->title('ID'),
            Column::make('name') // Nombre del Empleado
                  ->title('Nombre'),
            Column::make('email') // Correo del Empleado
                  ->title('Correo Electrónico'),
            Column::make('position') // Puesto del Empleado
                  ->title('Puesto'),
            Column::make('department') // Departamento del Empleado
                  ->title('Departamento'),
            Column::make('created_at') // Fecha de Creación
                  ->title('Fecha Creación'),
            Column::computed('action') // Columna de acciones
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Employees_' . date('YmdHis');
    }
}

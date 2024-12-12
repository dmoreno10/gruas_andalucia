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
            ->editColumn('created_at', function (Employee $model) {
                return $model->created_at->format('d/m/Y H:i:s'); // Formato de la fecha
            })
            ->addColumn('company', function (Employee $model) {
                return $model->company ? $model->company->name : 'Sin empresa'; // Muestra el nombre de la empresa
            })
            ->addColumn('action', 'employees.action')
            ->setRowId('id'); // Establecer ID de fila
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->newQuery()->with('company'); // Obtener empleados ordenados por ID
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('employees-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange();
}

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name') 
                ->title('Nombre'),
            Column::make('email') 
                ->title('Correo Electrónico'),
            Column::make('position') 
                ->title('Puesto'),
            Column::make('department') 
                ->title('Departamento'),
            Column::make('created_at')
                ->title('Fecha Creación'),
            Column::computed('company') 
            ->title('Empresa')
            ->exportable(false)  
            ->printable(false)   
            ->addClass('text-center'), 
            Column::computed('action')
                ->title('Acciones')
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

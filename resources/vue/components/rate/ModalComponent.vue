<template>
    <div class="modal-overlay" @click="$emit('close')">
        <div class="modal-content" @click.stop>
            <span class="close" @click="$emit('close')">&times;</span>
            <h2 class="modal-title">Información de Tarifas</h2>
            <i :class="icon" class="modal-icon"></i>

            <div class="info-section">
                <h3>Valores de Tarifas</h3>
                <p><strong>Por Día:</strong> $10.00</p>
                <p><strong>Por Mes:</strong> $250.00</p>
                <p><strong>Por Año:</strong> $2500.00</p>
            </div>

            <div class="download-section">
                <button class="btn-download" @click="downloadPDF">
                    <i class="fas fa-file-download"></i> Descargar PDF
                </button>
                <button class="btn-back" @click="$emit('close')">
                    Volver
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable'; // Importar autoTable

export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
    },
    methods: {
        downloadPDF() {
            const doc = new jsPDF();

            // Título del PDF
            doc.setFontSize(20);
            doc.text("Información de Tarifas del Depósito Municipal de Vehículos", 14, 20);

            // Establecer estilo para el contenido
            doc.setFontSize(14);
            doc.setTextColor(40);
            doc.text("Este documento detalla las tarifas aplicadas para el almacenamiento de vehículos en el depósito municipal.", 14, 40);

            // Tabla de tarifas
            const tableData = [
                ["Tipo", "Precio"],
                ["Por Día", "$10.00"],
                ["Por Mes", "$250.00"],
                ["Por Año", "$2500.00"],
            ];

            autoTable(doc, {
                head: tableData.slice(0, 1),
                body: tableData.slice(1),
                startY: 50,
                theme: 'grid',
                styles: { fontSize: 12, cellPadding: 4 },
            });

            // Detalles adicionales
            let nextY = doc.autoTable.previous.finalY + 15; // Ajuste para espacio entre la tabla y detalles
            doc.setFontSize(12);
            doc.setTextColor(100);
            doc.text("Detalles Adicionales Importantes:", 14, nextY);
            nextY += 10; // Ajustamos la posición para el siguiente texto

            doc.setTextColor(40);
            const details = [
                "- El costo incluye el almacenamiento seguro del vehículo.",
                "- Tarifas por retraso: $5.00 por día adicional después de los primeros 30 días.",
                "- Tarifas especiales pueden aplicar a vehículos de gran tamaño.",
                "- Requiere presentación de documentación adecuada para la recuperación del vehículo.",
                "- Horarios de atención para retiro: Lunes a Viernes de 9 AM a 5 PM.",
                "- Se ofrecen opciones de pago flexibles en efectivo, tarjeta de crédito y débito.",
                "- Proceso de recuperación del vehículo: verificar documentación y realizar el pago.",
                "- Tarifas sujetas a cambios; consulte la normativa local."
            ];

            // Imprimir cada detalle con ajuste de espacio
            details.forEach(line => {
                doc.text(line, 14, nextY);
                nextY += 8; // Aumentar el espacio entre líneas
            });

            // Mensaje de cierre
            nextY += 10; // Espacio antes del mensaje de cierre
            doc.setTextColor(100);
            doc.text("¡Gracias por su atención!", 14, nextY);
            nextY += 5; // Espacio entre líneas
            doc.text("Para más información, por favor visite nuestro sitio web o contáctenos.", 14, nextY);

            // Guardar PDF
            doc.save('informacion_tarifa.pdf');
        },
        getTariffType() {
            switch (this.icon) {
                case 'fas fa-truck':
                    return 'Camiones';
                case 'fas fa-bicycle':
                    return 'Bicicletas';
                case 'fas fa-car':
                    return 'Vehículos Ingresados';
                case 'fas fa-motorcycle':
                    return 'Motos';
                case 'fas fa-trailer':
                    return 'Remolques';
                case 'fas fa-user':
                    return 'Petición de Particulares';
                default:
                    return 'Desconocido';
            }
        }
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8); /* Fondo oscuro */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999; /* Asegura que esté encima de otros elementos */
}

.modal-content {
    background: linear-gradient(to bottom right, #f8f9fa, #e2e6ea); /* Degradado suave */
    border-radius: 12px; /* Bordes más suaves */
    padding: 30px; /* Espacio adicional para una mejor distribución */
    text-align: center;
    position: relative;
    width: 400px; /* Ancho fijo para el modal */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Sombra suave para profundidad */
    transition: transform 0.3s; /* Suavizar la entrada del modal */
}

.close {
    position: absolute;
    top: 15px;
    right: 20px;
    cursor: pointer;
    font-size: 24px; /* Tamaño del icono de cerrar más grande */
    color: #dc3545; /* Color rojo para el icono de cerrar */
}

.modal-title {
    font-size: 24px; /* Tamaño del título */
    color: #007bff; /* Color azul del título */
    margin-bottom: 15px; /* Espaciado debajo del título */
}

.modal-icon {
    font-size: 60px; /* Tamaño del icono */
    color: #007bff; /* Color del icono */
    margin-bottom: 15px; /* Espacio debajo del icono */
}

.info-section {
    margin: 20px 0; /* Espaciado para la sección de información */
}

.download-section {
    margin-top: 20px; /* Espaciado para la sección de descarga */
    display: flex;
    justify-content: center; /* Centra los botones */
    gap: 10px; /* Espaciado entre botones */
}

.btn-download,
.btn-back {
    background-color: #007bff; /* Color de fondo */
    color: white; /* Color del texto */
    border: none; /* Sin bordes */
    border-radius: 5px; /* Bordes redondeados */
    padding: 12px 20px; /* Espaciado interno */
    cursor: pointer; /* Cambia el cursor al pasar el ratón */
    transition: background-color 0.3s, transform 0.2s; /* Transición suave para el efecto hover */
}

.btn-download:hover,
.btn-back:hover {
    background-color: #0056b3; /* Color de fondo al pasar el ratón */
    transform: translateY(-2px); /* Efecto de elevación al pasar el ratón */
}

.btn-back {
    background-color: #6c757d; /* Color de fondo diferente para el botón de volver */
}

.btn-back:hover {
    background-color: #5a6268; /* Color de fondo al pasar el ratón para volver */
}
</style>

<?php
include("funciones.php");//se hace llamado al archivo que contiene las funciones obtenerUltimoID(), generarNombre().
include("variables.php");//variables de entorno

// Verificar si se han enviado los detalles del carrito y el total a través de la URL
if(isset($_GET['carrito']) && isset($_GET['total'])) {

    // Decodificar los detalles del carrito desde JSON
    $detallesCarrito = json_decode($_GET['carrito'], true);

    // Verificar si los detalles del carrito se decodificaron correctamente
    if($detallesCarrito !== null) {
        // Obtener el total desde la URL
        $total = $_GET['total'];

        // Mostrar los detalles del carrito y el total
        require('fpdf/fpdf.php');

        // Crear instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Agregar logo
        $pdf->Image('img/logo.png',10,10,30);

        // Configurar fuente y tamaño de texto
        $pdf->SetFont('Arial','B',16);

        // Título
        $pdf->Cell(0,10,'Factura',0,1,'C');
        $pdf->Ln(10);

        // Número de pedido
        $pdf->SetFont('Arial','',12);
        //aqui se utiliza la variable $num_reporte que guarda el valor del ultimo ID en la tabla tbl_reportes
        $pdf->Cell(0,10,'Número de Pedido:'.obtenerUltimoID(), 0,1,'L');
        $pdf->Ln(5);

        // Cabecera de la tabla
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(80,10,'Producto',1,0,'C');
        $pdf->Cell(40,10,'Cantidad',1,0,'C');
        $pdf->Cell(40,10,'Total',1,1,'C');

        // Contenido de la tabla
        $pdf->SetFont('Arial','',12);
        foreach($detallesCarrito as $producto) {
            $pdf->Cell(80,10,$producto['title'],1,0,'C');
            $pdf->Cell(40,10,$producto['quantity'],1,0,'C');
            $pdf->Cell(40,10,$producto['price'],1,1,'C');
        }

        // Total
        $pdf->Ln(10);
        $pdf->Cell(120,10,'Total:',1,0,'R');
        $pdf->Cell(40,10,'$'.$total,1,1,'C');

        // Salida del PDF
        $pdf->Output($ruta_archivos.generarNombre(), 'F');

        //redireccionar a la pagina mails para enviar el pedido por correo
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=mails.php?ENVIAR">';

    } else {
        // En caso de que no se haya podido decodificar el JSON de los detalles del carrito
        echo "Error: No se pudieron decodificar los detalles del carrito.";
    }
} else {
    // En caso de que no se hayan enviado los detalles del carrito y el total a través de la URL
    echo "No se han enviado detalles del carrito y total.";
}
?>

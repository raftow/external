<?php
    $max_execution_time = ini_get('max_execution_time');
    die("max_execution_time = $max_execution_time");
    ob_start();
    include("content_pdf.php");
    $content = ob_get_clean();
    require_once(dirname(__FILE__).'../lib/html2pdf/html2pdf.class.php');
    try
    {   
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("doc_needs_$pm_id.pdf");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

<?php 
if($_POST && isset($_POST['table_reporte']) && isset($_POST['tipo_reporte']) ) {
  $titulo_reporte = 'Resolución de Reclamos y sugerencias';
  $filtro = array_unique([$_POST['desde_'],$_POST['hasta_']]);
  $filtro = implode(' / ', $filtro);
  $file_name = 'Reporte_resolucion_casos';
  $cantidad_columnas = 8;
  
  $logo = $host."images/sistema.png";
  
  $css_pdf = "
  .title_th { background:black; color:white;}
  th, td { padding-top: 5px;  padding-bottom: 5px;  padding-left: 5px;  padding-right: 5px; }
  ";
  
  $html_header_pdf = '
    <table width="100%" border="0" >
      <tr>
      <td width="20%" align="center"><img width="60px" src="'.$logo.'" /></td>
      <td width="60%" align="center"><h2>Gestión de reclamos y sugerencias HNR </h2><b>'.$titulo_reporte.'</b><br />'.$filtro.'</td>
      <td  width="20%" align="center">'.$_POST['usuario'].'<br />'. date('d/m/Y H:i:s').'</td>
      <tr>
    </table>
    <div width="100%" style="border-top:1px solid black;">&nbsp;</div>
  ';
  
  
  
  $html_header_excel = '
    <table width="100%" border="0" >
      <tr>
      <td colspan = "'.($cantidad_columnas - 1).'" align="center">
      <h2>Gestión de reclamos y sugerencias HNR </h2><b>'.$titulo_reporte.'</b><br />'.$filtro.'</td>
      <td align="center">'.$_POST['usuario'].'<br />'. date('d/m/Y H:i:s').'</td>
      <tr>
    </table>
  ';
  
    $html_reporte = trim($_POST['table_reporte']);
    if($_POST['tipo_reporte'] == 1) {
      $footer = '<div align="center" style="border-top:1px solid black;" align="right"><b>Pág. {PAGENO} / {nb}</b></div>';
      $mpdf->SetHTMLFooter($footer);
      $mpdf->SetHTMLFooter($footer,'E');
      $mpdf->SetTitle('Reporte resolución');
  
      if(substr_count(strtolower($_SERVER['SERVER_NAME']), 'azure') > 0) {
        $mpdf->AddPage('L');
      }
  
      $mpdf->WriteHTML($css_pdf,1);	
      $mpdf->WriteHTML($html_header_pdf.$html_reporte);
      $mpdf->Output($file_name.'.pdf', 'I');
    } else {
      $filename = $file_name.".xls";
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=".$filename);
      echo '<meta charset="utf-8">';
      echo $html_header_excel.$html_reporte;
    }
  } else {
  header("Location: $host");
  }
<?php
ob_start();
	include_once('simple_html_dom.php');
	include_once('Classes/PHPExcel.php');

	set_time_limit(0);
	
		$document = PHPExcel_IOFactory::load($_COOKIE['file']);
		header('Content-type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment; filename="file.xls"');
		ob_end_clean();
		$objWriter = PHPExcel_IOFactory::createWriter($document, 'Excel5');
	    $objWriter->save('php://output');
			
ob_end_flush();

?>
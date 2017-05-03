<?php
ob_start();
	include_once('simple_html_dom.php');
	include_once('Classes/PHPExcel.php');
	set_time_limit(0);
	 //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

	if (!empty($_POST)) {


		if( $_POST['field_check'] == 'separate_cols'){

			if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['phone'])) {

				//echo 'Please provide FirstName and LastName and Phone Field.';
				// $urll = 'http://'.$_SERVER['HTTP_HOST'].'/phone/index.php';
    //             header( "refresh:3; url=$urll"); 
			}
			else{

	 			process_file_separate_names($_POST['field_check'], $_POST['fullName'], $_POST['fname'], $_POST['lname'], $_POST['state'], $_POST['zip'], $_POST['phone'], $_POST['page_no']);
			}

		}
		elseif ($_POST['field_check'] == 'same_cols') {
			if (empty($_POST['fullName']) || empty($_POST['phone']) ) {
				//echo 'Please provide FullName and Phone Field.';
				// $urll = 'http://'.$_SERVER['HTTP_HOST'].'/phone/index.php';
    //             header( "refresh:3; url=$urll"); 				
			}
			else{
				process_file_separate_names($_POST['field_check'], $_POST['fullName'], $_POST['fname'], $_POST['lname'], $_POST['state'], $_POST['zip'], $_POST['phone'], $_POST['page_no']);
			}
		}
	}
	
	function 	process_file_separate_names($field_check, $fullName, $fname, $lname, $state, $zip, $phone, $page_no){

		$inputFileName = $_COOKIE['file'];	
// Get the active sheet as an array

	try {
		$document = PHPExcel_IOFactory::load($inputFileName);
		//$document->setActiveSheetIndex(0);

		
	} catch(Exception $e) {
		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	$activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);

	$document->getActiveSheet()->SetCellValue($phone.(1), utf8_encode('Phone'));


	    $fullName = strtoupper($fullName);
		$fname = strtoupper($fname);
		$lname = strtoupper($lname);
		$state = strtoupper($state);
		$zip = strtoupper($zip);
		$phone = strtoupper($phone);

 		$total_pages = 0;
 		$total_pages = ceil((count($activeSheetData) / 15));
 		$start = ($page_no*15) - 15;
 		$end = $page_no*15;
 		if($page_no == 1){
 			$i=1;
 			$sliced_array = array_slice($activeSheetData, $start+1, $end);
 		}
 		else{
 			$i=$start;
 			$sliced_array = array_slice($activeSheetData, $start, $end);
 		}
		
// echo "string";
// print_r($sliced_array);
// exit();

	
	foreach ($sliced_array as $row) {

		if($page_no <= $total_pages){

		//if($i != 0 && $page_no != 1){	

		   // check for full name in single column
		   if($field_check == 'same_cols'){
			
			$url_name = 'name/'; 
			

			if ($fullName == 'A') {
		  		
		  		$name = explode(' ', trim($row['A']));
		  	}
		  	if ($fullName == 'B') {
		  		
		  		$name = explode(' ', trim($row['B']));
		  	}
		  	if ($fullName == 'C') {
		  		$name = explode(' ', trim($row['C']));
		  	}
		  	if ($fullName == 'D') {
		  		$name = explode(' ', trim($row['D']));
		  	}


			foreach ($name as $name_broken) {
				$url_name = $url_name.$name_broken.'-';
			}
			$url_name = rtrim($url_name, '-');
		  }
		  //// check for name in separate columns
		  else if ($field_check == 'separate_cols') {

		  	$url_name = 'name/'; 


		  	

		  	if ($fname == 'A') {
		  		$fname1 = explode(' ', trim($row['A']));
		  	}
		  	if ($fname == 'B') {
		  		$fname1 = explode(' ', trim($row['B']));
		  	}
		  	if ($fname == 'C') {
		  		$fname1 = explode(' ', trim($row['C']));
		  	}
		  	if ($fname == 'D') {
		  		$fname1 = explode(' ', trim($row['D']));
		  	}

			foreach ($fname1 as $name_broken) {
				$url_name = $url_name.$name_broken.'-';
			}

		  	if ($lname == 'A') {
		  		$lname1 = explode(' ', trim($row['A']));
		  	}
		  	if ($lname == 'B') {
		  		$lname1 = explode(' ', trim($row['B']));
		  	}
		  	if ($lname == 'C') {
		  		$lname1 = explode(' ', trim($row['C']));
		  	}
		  	if ($lname == 'D') {
		  		$lname1 = explode(' ', trim($row['D']));
		  	}	

			foreach ($lname1 as $name_broken) {
				$url_name = $url_name.$name_broken.'-';
			}
			$url_name = rtrim($url_name, '-');
		  }


		  if (!empty($state)) {

			$url_address = '/';
			$row['B'] = str_replace(',', '', $row[$state]);
			$address = explode(' ', $row['B']);
			foreach ($address as $address_broken) {
				$url_address = $url_address.$address_broken.'-';
			}

			$url_address = rtrim($url_address, '-');
			
		}
         if (!empty($zip)) {
         	$url_zip = explode('-', $row[$zip])[0];
         }
			
			$final_url = 'https://thatsthem.com/'.$url_name.$url_address.'-'.$url_zip;

			//print_r($final_url);exit();
//$document->getActiveSheet()->SetCellValue('L'.($i+1), utf8_encode($final_url));

			$phone1 = get_url_data($final_url);

			$abc = $document->getActiveSheet()->SetCellValue($phone.($i+1), utf8_encode($phone1));
			
			//$objWriter->save();
			//exit();
//print_r($document->getActiveSheet()); exit();
			
			
		//}
	}

		$i++;
	}
	
			$objWriter = new PHPExcel_Writer_Excel2007($document);
			$objWriter->save($_COOKIE['file']);
			//download_file();
			 
    	print_r(json_encode(['page_no' => $page_no , 'total_pages' => $total_pages]));
}



	function get_url_data($url){
		//$url = 'https://thatsthem.com/name/Mark-Jaindl/1964-Diehl-Court-18104';
	 //$output = file_get_contents($url); 
	//echo $output;
		
		$html = file_get_html($url);
		//print_r($html);exit;
		if(empty($html)){
			return 'not found';
		}
		else{

		if(count($html->find('.container .no-result')) > 0){
			return 'not found';
		}
		else{
			foreach($html->find('h3 .no-linky span') as $row) {

				$val = preg_replace("/<span[^>]+\>/i", "", $row);
				$val = str_replace("</span>", "", $val);
				return $val;
			}
		} 

	  }		
	}
ob_end_flush();
?>
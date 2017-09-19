<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('/', 'Login@index');
Route::get('login', 'Login@index');

Route::resource('account', 'Account');
Route::resource('policy', 'Policy');
Route::resource('sample', 'Sample');
Route::resource('excel', 'ExcelDemo');
Route::resource('upload', 'UploadFile');
Route::resource('search', 'Search');
Route::resource('encode', 'EncodeApplication');

Route::post('search/filter', 'Search@filter');
Route::post('search/autoLink', 'Search@autoLink');
Route::post('search/viewAppDetails', 'Search@viewAppDetails');
Route::post('search/deleteRecord', 'Search@deleteRecord');


Route::get('search/comelink/{application_id}', 'Search@comlink');
Route::get('search/comelec/{application_id}', 'Search@comelec');


/*
Route::resource('userlogin', 'UserLogin');

*/
Route::get('success', function(){
	return view("common.body1");
});


Route::get('excel_demo', function(){
    
    try {
        $fileName = "./uploads/Book1.xlsx";
        $fileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($fileType); // $fileType
        $objPHPExcel = $objReader->load($fileName);
        $sheets = [];
        $sheetNames = [];                
        
        foreach ($objPHPExcel->getAllSheets() as $sheet) {                        
            $sheetNames[] = $sheet->getTitle();            
            $sheets[$sheet->getTitle()] = $sheet->toArray();   
        }
        
        //return $sheets;
        //dd($sheetNames);
        //dd($sheets);
        echo"<pre>";print_r($sheetNames);echo"</pre>";
        echo"<pre>";print_r($sheets);echo"</pre>";
    } catch (Exception $e) {        
        echo "Error: ". $e->getMessage();
    }     
    
    die();
    
    /*
    $path = "./uploads/file2.xlsx";
    $inputFileName = "./uploads/file2.xlsx";
    
    //  Read your Excel workbook
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
        die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

    //  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();       
    $sheetsnames = $objPHPExcel->getSheetNames();
    
    echo"HighestRow:<pre>";print_r($highestRow);echo"</pre>";
    echo"HighestColumn:<pre>";print_r($highestColumn);echo"</pre>";
    echo"HighestRow:<pre>";print_r($highestRow);echo"</pre>";    
    
    
    $i = 0;
    while ($objPHPExcel->setActiveSheetIndex($i)){

        $objWorksheet = $objPHPExcel->getActiveSheet();
        echo"<pre>";print_r($sheetsnames[$i]);echo"</pre>";
        //echo"<pre>";print_r($objWorksheet);echo"</pre>";
        
        //now do whatever you want with the active sheet
        $i++;

    }
    */
    
    /*
    //  Loop through each row of the worksheet in turn
    for ($row = 1; $row <= $highestRow; $row++){
        echo"<pre>";print_r('A' . $row . ':' . $highestColumn . $row);echo"</pre>";
        
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                        NULL,
                                        TRUE,
                                        FALSE);
        //  Insert row data array into your database of choice here
        echo"<pre>";print_r($rowData[0]);echo"</pre>";
    }
    */
    
    
    /*
    try {
        $inputFileType = PHPExcel_IOFactory::identify($path);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($path);
    } catch (Exception $ex) {
        die($ex->getMessage());
    }    
    
    $sheets = $objPHPExcel->getSheetCount();
    $sheetsnames = $objPHPExcel->getSheetNames();
    echo "COunt: ". $sheets."<br>";
    echo"<pre>";print_r($sheetsnames);echo"</pre>";
    
    
    $sheets = $objPHPExcel->getSheet(0);
    $highestRow = $sheets->getHighestRow();
    $highestColumn = $sheets->HighestColumn();
    
    for($x = 1; $x <= $highestRow; $x++) {
        // Row
        $headings = $sheets->rangeToArray('A1:' . $highestColumn . 1,
                                            NULL,
                                            TRUE,
                                            FALSE);
        echo"<pre>";print_r($heading);echo"</pre>";
    }
    */
    
    //$data = array(1,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
    //echo"<pre>";print_r($data);echo"</pre>";
    
});



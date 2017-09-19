<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

// PHP Excel Library
use PHPExcel;
use PHPExcel_IOFactory;

use Illuminate\Support\Facades\File;

use App\Models\MdlApplication;
use App\Models\MdlComelec;

class UploadFile extends Controller {
    
    public function __construct() {
        $this->middleware("auth");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        /*
        $results = array();
        $apps = MdlApplication::where("borrower_name", "SANTOS, OLIVER MACLANG JR.")->get();
        foreach($apps as $app) {
            $r = $app->getComelect()->get()->toArray();
            $results = array_merge($results, $r);
        }
        dd($results);
        */
        
        return view("account.upload");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        
        $msg = array();
        $inputs = Input::all();
        
        if(isset($inputs['myfiles'])) {
            if(Input::file("myfiles")->isValid()) {
                $msg['isValid'] = true;
                $ext  = Input::file("myfiles")->getClientOriginalExtension();            
                $name = time().".".$ext;
                // Upload            
                Input::file("myfiles")->move("./uploads", $name);
                
                $msg['uploaded'] = true;
                $msg['file_name'] = $name;
                
                // Select Upload File Type
                if(isset($inputs['select_upload_file']) && $inputs['select_upload_file'] == 'borrower') {
                    $msg['select_upload_file'] = 'borrower';
                    $res = $this->readExcelFile($name, 'borrower');
                    $msg = array_merge($msg, $res);
                } else {
                    $msg['select_upload_file'] = 'comelec';
                    $res = $this->readExcelFile($name, 'comelec');
                    $msg = array_merge($msg, $res);
                }             
                
            } else {
                $msg['isValid'] = false;
            }
        }
        
        $msg["_token"] = csrf_token();               
        
        echo json_encode($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
    
    private function readExcelFile($filename, $type) {        
        $path = null;
        $msg = array();
        $tmpCols = array();
        $cols = array();
        $mdl = NULL;
                
        if($type == 'borrower') {
            $mdl = new MdlApplication();
            $cols = $mdl->getTableColumns();
            
            unset($cols[0]);
            unset($cols[31]);
            unset($cols[32]);
            foreach($cols as $c => $cc) {
                $tmpCols[] = $cc;
            }
            $cols = $tmpCols;
            
        } else { // Comelec
            $mdl = new MdlComelec();
            $cols = $mdl->getTableColumns();
            
            unset($cols[0]);
            unset($cols[6]);
            unset($cols[7]);
            foreach($cols as $c => $cc) {
                $tmpCols[] = $cc;
            }
            $cols = $tmpCols;
        }
        
        $sheets = [];
        $sheetNames = []; 
        
        try {            
            $path = "./uploads/".$filename;
            $fileType = PHPExcel_IOFactory::identify($path);
            $objReader = PHPExcel_IOFactory::createReader($fileType);
            $objPHPExcel = $objReader->load($path);            
            
            foreach ($objPHPExcel->getAllSheets() as $sheet) {                        
                $sheetNames[] = $sheet->getTitle();
                $sheets[$sheet->getTitle()] = $sheet->toArray();   
            }
            
        } catch (Exception $e) {        
            $msg['error'] = $e;
        }
        
        $msg['data'] = $sheets;		       
        
        $recSheets = array();
        foreach($sheets as $key => $sheet) {
            $index = 0;            
            foreach($sheet as $k => $shet) {
                if($k >= 1) {                    
                    for($x=0; $x < count($cols); $x++) {                          
                        $recSheets[$key][$index][$cols[$x]] = $shet[$x];                        
                    }
                    $index++;
                }               
            }           
        }
        
        //$msg['recSheets'] = $recSheets;
        $totalRec = 0;
        $totalError = 0;
        
        foreach($recSheets as $recSheet) {
            foreach($recSheet as $key => $record) {
                $application = NULL;
                // Check upload type
                if($type == 'borrower') {
                    $application = new MdlApplication($record);
                } else {
                    $application = new MdlComelec($record);
                }
                // Save
                if($application->save()) {
                    $totalRec++;
                } else {
                    $totalError++;
                }
            }
        }

        $msg['total_rows_affected'] = $totalRec;
        $msg['total_error'] = $totalError;

        // delete file        
        try {
            File::Delete($path);
            $msg['file_deleted'] = true;
        } catch (Exception $ex) {
            $msg['file_deleted'] = $ex->getMessage();
        }
        
        return $msg;
    }

}

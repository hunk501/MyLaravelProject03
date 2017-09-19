<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\MdlApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\MdlComelec;

class Search extends Controller {

	private $DUPLICATE_ID = array();
	
	public function __construct() {
		$this->middleware('auth');
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {	
    	/*
    	$users = Auth::user();
    	dd($users->toArray());
    	die();
    	*/
        return view("account.search");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
		return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $inputs = Input::all();        

		$validator = Validator::make($inputs, $this->getRules());
		if($validator->fails()) {
			return redirect('search/create')->withErros($validator)->withInput($inputs);
		} else {
			dd($inputs);
		}        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // MARIDEL DESAMERO/TRISH DANES SEMPIO/SHERWIN LEJARDE/EMMANUEL EISMA/ROSALIE SANTIAGO  
        /**
         * Spouse=OK, Co-Maker=OK, Co-Borrower=OK, Character Reference
         */
        $co_borrower = NULL;
        $character_reference = NULL;
        $co_maker = NULL;
        $spouse = NULL;
        $borrower_name = NULL;
        
        $output = array();
        
        $records = MdlApplication::where("id", $id)->get();
        if(!empty($records)) {
            foreach($records as $record) {
                /*
            	$expl = explode(",", $record->borrower_name);
                $fname = explode(" ", trim($expl[1]));
                if(count($expl) >= 1 && count($fname) > 0) {
                    $character_reference = trim($expl[1])." ".trim($expl[0]); //$fname[0]." ".$expl[0]; // Firstname Lastname
                    $co_borrower = $record->borrower_name;
                }
                */
                $spouse = $record->spouse;
                $co_borrower = $record->co_borrower;
                $co_maker = $record->comaker;
                $character_reference = $record->character_reference;
                $borrower_name = $record->borrower_name;                
            }
        }
        
        return view("account.auto_link")
                ->with([
                		'borrower_name' => $borrower_name,
                		'id' => $id
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

    	$check = MdlApplication::where('id', $id)->first();
    	if(!empty($check)) {			
    		//dd($check->toArray());
			return view('account.edit')->with(['record' => $check->toArray()]);
    	} else {
			return view('errors.not_found');
		}
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
    
    /**
     * Get CO-Borrower
     * @param unknown $name
     */
    private function getCoBorrower($name) {
    	$results = array();
    	// Format: LIRA, DENNIS DASH
    	$spltName = explode(",", $name);
    	if(count($spltName) > 1) {    		    		  
    		
    		$query = MdlApplication::where('borrower_name', 'LIKE', trim($spltName[0])."%")->get()->toArray();
    		if(!empty($query)) {
    			foreach($query as $value) {
    				
    				// BORROWER NAME = Co-Borrower    				    			
    				$spltCoBorrower = explode(",", $value['borrower_name']);
    				if(count($spltCoBorrower) > 1) {
    					
    					// Check if lastname match
    					if(strtolower(trim($spltName[0])) == strtolower(trim($spltCoBorrower[0])) ) {    						    					
							
    						$fname = str_replace(".", "", $spltName[1]);
    						$fnamCoBorrower = str_replace(".", "", $spltCoBorrower[1]);
    						
    						// Check if firstnaame match
    						if(str_contains(strtolower($fname), strtolower(trim($fnamCoBorrower)))) { 
    							$value['relation_found'] = 'Co-Borrower';
    							array_push($results, $value);
    						}
    					}
    				}
    				
    			}
    		}    		
    	}
    	
    	return $results;
    }
    
    /**
     * Get CO-Maker
     * @param unknown $name
     */
    private function getCoMaker($name) {
    	$results = array();
    	// Format: LIRA, DENNIS DASH
    	$spltName = explode(",", $name);
    	    	
    	if(count($spltName) > 1) {
    	
    		$query = MdlApplication::where('borrower_name', 'LIKE', trim($spltName[0])."%")->get()->toArray();
    		if(!empty($query)) {
    			foreach($query as $value) {
    	
    				// BORROWER NAME = Co-Maker
    				$spltCoMaker = explode(",", $value['borrower_name']);    				
    				if(count($spltCoMaker) > 1) {
    						
    					// Check if lastname match
    					if(strtolower(trim($spltName[0])) == strtolower(trim($spltCoMaker[0])) ) {
    							
    						$fname = str_replace(".", "", $spltName[1]);
    						$fnamCoBorrower = str_replace(".", "", $spltCoMaker[1]);
    	
    						// Check if firstnaame match
    						if(str_contains(strtolower($fname), strtolower(trim($fnamCoBorrower)))) {
    							$value['relation_found'] = 'Co-Maker';
    							array_push($results, $value);
    						}
    					}
    				}
    	
    			}
    		}
    	}
    	 
    	return $results;
    }
    
    /**
     * Get Spouse
     * @param unknown $name
     */
    private function getSpouse($name) {
    	$results = array();
    	// Format: LIRA, DENNIS DASH
    	$spltName = explode(",", $name);
    	
    	if(count($spltName) > 1) {
    		 
    		$query = MdlApplication::where('borrower_name', 'LIKE', trim($spltName[0])."%")->get()->toArray();
    		if(!empty($query)) {
    			foreach($query as $value) {
    				 
    				// BORROWER NAME = Spouse
    				$spltCoMaker = explode(",", $value['borrower_name']);
    				if(count($spltCoMaker) > 1) {
    	
    					// Check if lastname match
    					if(strtolower(trim($spltName[0])) == strtolower(trim($spltCoMaker[0])) ) {
    							
    						$fname = str_replace(".", "", $spltName[1]);
    						$fnamCoBorrower = str_replace(".", "", $spltCoMaker[1]);
    						 
    						// Check if firstnaame match
    						if(str_contains(strtolower($fname), strtolower(trim($fnamCoBorrower)))) {
    							$value['relation_found'] = 'Spouse';
    							array_push($results, $value);
    						}
    					}
    				}
    				 
    			}
    		}
    	}
    	
    	return $results;
    }
    
    /**
     * Get Character Reference
     * @param unknown $names
     */
    private function getCharacterReference($names, $id) {
    	
    	$character_ref_result = array();
    	
    	$spltNames = explode("/", $names);
    	
    	if(!empty($spltNames)) {
    		$temp = array();
    		foreach($spltNames as $character_ref) {
    			    			
    			$spltCharacterRef = explode(" ", trim($character_ref));
    			//$spltCharacterRef = array_reverse($spltCharacterRef); // Reverse ( [0] => Lastname, [1] => Firstname etc...... )
    			$count = count($spltCharacterRef);
    			if($count > 0) {
    				$extra = NULL;
    				$lastname_index = $count - 1;
    				$last_index = $spltCharacterRef[$lastname_index];
    				
    				if(in_array(trim(strtolower($last_index)), array('sr','sr.','jr','jr.'))) {
    					$extra = $last_index;
    					$lastname_index = $count - 2;
    					$last_index = $spltCharacterRef[$lastname_index];    					
    				}
    				
    				$last_name = str_replace("(DECEASED)", "", $last_index);
    				
    				$firstname = "";
    				for($i=0; $i < $lastname_index; $i++) {
    					$firstname .= $spltCharacterRef[$i];
    					if(($i + 1) < $lastname_index) {
    						$firstname .= " ";
    					}
    				}
    				
    				$temp[] = array(
    						'lastname' => $last_name,
    						'lastname_index' => $lastname_index,
    						'firstname' => $firstname,
    						'extra' => $extra,
    						'data' => $spltCharacterRef
    				);
    			}
    			
    			//echo"<pre>";print_r($spltCharacterRef);echo"</pre>";
    		}
    		
    		if(!empty($temp)) {
    			foreach($temp as $key => $value) {
    				
    				//echo "Lastname: ". $value['lastname'] ."<br>";
    				$query = MdlApplication::where('borrower_name', 'LIKE', trim($value['lastname'])."%")
    							->where('id' ,'<>', $id)->get()->toArray();
    				if(!empty($query)) {    					
    					foreach($query as $result) {
    						$splResult = explode(",",$result['borrower_name']);
    						if(count($splResult) >= 2) {
    							// Check if lastname match 
    							if(strtolower(trim($splResult[0])) == strtolower(trim($value['lastname']))) {
    								// Check firstname if contains    								
    								$found = TRUE;
    								$splTempFname = explode(" ", $value['firstname']);
    								
    								foreach($splTempFname as $fname) {
    									if(str_contains(strtolower($splResult[1]), strtolower(trim($fname)))) {
    										//echo "FOUND <br>";
    									} else {
    										$found = FALSE;
    									}
    								}
    								
    								// Found
    								if($found) {
    									$result['relation_found'] = 'Character Reference';
    									array_push($character_ref_result, $result);
    								}
    							}
    						}
    					}
    				}
    			}
    		}    		
    	}
    	
    	//echo"<pre>";print_r($character_ref_result);echo"</pre>";    	
    	return $character_ref_result;
    }    	
	
    private function getAllFilter($name, $arrRecordId) {
    	$results = array();
    	// Format: LIRA, DENNIS DASH
    	$spltName = explode(",", $name);
    	//dd($arrRecordId);
    	if(count($spltName) > 1) {
    		
    		$query = MdlApplication::where('spouse', 'LIKE', trim($spltName[0]).'%')
    								->orWhere('comaker', 'LIKE', trim($spltName[0]).'%')
    								->orWhere('co_borrower', 'LIKE', trim($spltName[0]).'%')
    								->orWhere('character_reference', 'LIKE', '%'.trim($spltName[0]).'%')
    								->get()->toArray();
			if(!empty($query)) {
				foreach($query as $record) {
					// Check if ID is not existing from array
					if(!$this->isIDExists($arrRecordId, $record['id'])) {
						
						// Spouse
						$spltSpouse = explode(",", $record['spouse']);
						if(count($spltSpouse) > 1 && strtolower(trim($spltSpouse[0])) == strtolower(trim($spltName[0])) ) {
							$fname1 = str_replace(".", "", $spltSpouse[1]);
							$fname2 = str_replace(".", "", $spltName[1]);
							if(str_contains(strtolower(trim($fname1)), strtolower(trim($fname2)))) {
								//echo"Found - Spouse<br>";
								$res = $this->getSpouse($record['borrower_name']);								
								$results = array_merge($results, $res);
							}							
						}
						
						// Co-Maker
						$spltCoMaker = explode(",", $record['comaker']);
						if(count($spltCoMaker) > 1 && strtolower(trim($spltCoMaker[0])) == strtolower(trim($spltName[0])) ) {
							$fname1 = str_replace(".", "", $spltCoMaker[1]);
							$fname2 = str_replace(".", "", $spltName[1]);
							if(str_contains(strtolower(trim($fname1)), strtolower(trim($fname2)))) {
								//echo"Found - Co-Maker<br>";
								$res = $this->getCoMaker($record['borrower_name']);
								$results = array_merge($results, $res);
							}
						}
						
						// Co-Borrower
						$spltCoBorrower = explode(",", $record['co_borrower']);
						if(count($spltCoBorrower) > 1 && strtolower(trim($spltCoBorrower[0])) == strtolower(trim($spltName[0])) ) {
							$fname1 = str_replace(".", "", $spltCoBorrower[1]);
							$fname2 = str_replace(".", "", $spltName[1]);
							if(str_contains(strtolower(trim($fname1)), strtolower(trim($fname2)))) {
								//echo"Found - Co-Borrower<br>";
								$res = $this->getCoBorrower($record['borrower_name']);
								$results = array_merge($results, $res);
							}
						}
						
						// Character Reference
						$characterNames = $this->parseCharacterRefNames($record['character_reference']);
						if(!empty($characterNames)) {
							foreach($characterNames as $chrName) {
								if(strtolower(trim($chrName['lastname'])) == strtolower(trim($spltName[0]))) {
									$fname1 = str_replace(".", "", $chrName['firstname']);
									$fname2 = str_replace(".", "", $spltName[1]);
									if(str_contains(strtolower(trim($fname1)), strtolower(trim($fname2)))) {
										//echo"Found - Character Reference<br>";
										$checkName = MdlApplication::where('borrower_name', '=', $record['borrower_name'])
																->get()->toArray();
										if(!empty($checkName)) {
											foreach($checkName as $key => $ckName) {
												$checkName[$key]['relation_found'] = 'Character Reference';												
											}
											$results = array_merge($results, $checkName);
										}
									}
								}
							}
						}
					}
				}
			}
    	}
    	
    	return $results;
    }
    
    private function parseCharacterRefNames($names) {
    	$temp = array();
    	$spltNames = explode("/", $names);
    	if(!empty($spltNames)) {
    		foreach($spltNames as $character_ref) {
    			 
    			$spltCharacterRef = explode(" ", trim($character_ref));
    			//$spltCharacterRef = array_reverse($spltCharacterRef); // Reverse ( [0] => Lastname, [1] => Firstname etc...... )
    			$count = count($spltCharacterRef);
    			if($count > 0) {
    				$extra = NULL;
    				$lastname_index = $count - 1;
    				$last_index = $spltCharacterRef[$lastname_index];
    				 
    				if(in_array(trim(strtolower($last_index)), array('sr','sr.','jr','jr.'))) {
    					$extra = $last_index;
    					$lastname_index = $count - 2;
    					$last_index = $spltCharacterRef[$lastname_index];
    				}
    				 
    				$last_name = str_replace("(DECEASED)", "", $last_index);
    				 
    				$firstname = "";
    				for($i=0; $i < $lastname_index; $i++) {
    					$firstname .= $spltCharacterRef[$i];
    					if(($i + 1) < $lastname_index) {
    						$firstname .= " ";
    					}
    				}
    				 
    				$temp[] = array(
    						'lastname' => $last_name,
    						'lastname_index' => $lastname_index,
    						'firstname' => $firstname,
    						'extra' => $extra,
    						'data' => $spltCharacterRef
    				);
    			}
    		}	
    	}
    	
    	//echo"<pre>";print_r($temp);echo"</pre>";
    	return $temp;    	
    }
    
    private function isIDExists($arrRecordId, $id) {
    	foreach($arrRecordId as $rec_id) {
    		if($rec_id == $id) {
    			return TRUE;
    		}
    	}    	
    	return  FALSE;
    }       
    
    
    public function filter() {
        $inputs = Input::all();
        
        $search_text = $inputs['search_text'];
        $search_column = $inputs['search_column'];
        $application = MdlApplication::where($search_column, 'LIKE', "%$search_text%")->take(2000)->orderBy('borrower_name', 'ASC')->get();
        
        $inputs['total'] = count($application);
        $inputs['application'] = $application;
        echo json_encode($inputs);
    }
    
    
    public function autoLink() {
    	$inputs = Input::all();
    	$id = $inputs['record_id'];
    	
    	$co_borrower = NULL;
    	$character_reference = NULL;
    	$co_maker = NULL;
    	$spouse = NULL;
    	$borrower_name = NULL;
		$arrRecordId = array();
    	
    	$output = array();
    	$results = array();
    	
    	$records = MdlApplication::where("id", $id)->get();
    	if(!empty($records)) {
    		foreach($records as $record) {   
    			$arrRecordId[] = $record->id;
    			$spouse = $record->spouse;
    			$co_borrower = $record->co_borrower;
    			$co_maker = $record->comaker;
    			$character_reference = $record->character_reference;
    			$borrower_name = $record->borrower_name;
    		}
    	}
    	    	
    	/*
    	 echo "Co-Borrower: ". $co_borrower."<br>";
    	 echo "Character: ". $character_reference."<br>";
    	 echo "Co-Maker: ". $co_maker."<br>";
    	 echo "Spouse: ". $spouse."<br>";
    	*/
    	
    	$coBorrowers = $this->getCoBorrower($co_borrower);
		list($results, $arrRecordId) = $this->pushData($results, $arrRecordId, $coBorrowers);
    	
    	$coMaker = $this->getCoMaker($co_maker);
		list($results, $arrRecordId) = $this->pushData($results, $arrRecordId, $coMaker);
    	
    	$coSpouse = $this->getSpouse($spouse);    
		list($results, $arrRecordId) = $this->pushData($results, $arrRecordId, $coSpouse);
    	
    	$coCharacteReference = $this->getCharacterReference($character_reference, $id);
		list($results, $arrRecordId) = $this->pushData($results, $arrRecordId, $coCharacteReference);			
				
		$coFilterAll = $this->getAllFilter($borrower_name, $arrRecordId);
		list($results, $arrRecordId) = $this->pushData($results, $arrRecordId, $coFilterAll);
		
		$remove_keys = array();
		if(!empty($this->DUPLICATE_ID) && !empty($results)) {
			foreach($this->DUPLICATE_ID as $dup_id) {
				$first = true;
				$first_key = null;					
				foreach($results as $res_key => $result) {
					if($result['id'] == $dup_id) {
						if($first) {
							$first_key = $res_key;
							$first = false;
						} else {
							$remove_keys[] = $res_key;
							$temp_str = " | ".$result['relation_found'];
							$cur_str = $results[$first_key]['relation_found'];
							$results[$first_key]['relation_found'] = $cur_str . $temp_str;
						}
					}
				}
				
				
			}				
		}
		
		if(!empty($remove_keys)) {
			foreach($remove_keys as $rem) {
				unset($results[$rem]);
			}
		}
		
    	//echo"<h1>RESULT:</h1>";
    	//echo"Co-Borrower:<pre>";print_r($coBorrowers);echo"</pre>";
    	//echo"Co-Maker:<pre>";print_r($coMaker);echo"</pre>";
    	//echo"Co-Spouse:<pre>";print_r($coSpouse);echo"</pre>";
    	//echo"Co-CharacterReference:<pre>";print_r($coCharacteReference);echo"</pre>";
    	$output['records'] = $results;
    	$output['total'] = count($results);
    	$output['_token'] = csrf_token();
    	$output['arrRecordId'] = $arrRecordId;
    	
    	echo json_encode($output);
    }
    

    public function viewAppDetails() {
        $output = array();
        $inputs = Input::all();
        if(!empty($inputs['app_id'])) {
            $output['app_id'] = $inputs['app_id'];
            $model = new MdlApplication();
            $check = $model->where("id", $inputs['app_id'])->get();
                        
            $output['records'] = $check;
        }
        
        $output['_token'] = csrf_token();        
        echo json_encode($output);
    }

    public function deleteRecord() {
    	
    	$output = array();
    	$inputs = Input::all();
    	if(isset($inputs['app_id'])) {
    		MdlApplication::where('id', $inputs['app_id'])->delete();
    		$output['status'] = true;
    	} else {
    		$output['status'] = false;
    	}
    	
    	$output['_token'] = csrf_token();    	
    	echo json_encode($output);
    }
    
    public function comlink($application_id) {
    	
    	if(!empty($application_id)) {
    		$borrower_name = null;
    		$records = MdlApplication::where("id", $application_id)->get();
    		if(!empty($records->toArray())) {
    			$record = $records->toArray();
    			$borrower_name = $record[0]['borrower_name'];
    		}
    		return view('account.comelec')->with([
    				'application_id' => $application_id,
    				'borrower_name' => $borrower_name
    		]);
    	}
    	
    	return view('errors.not_found');
    }
    
    public function comelec($application_id) {
    	
    	$output = array();
    	$borrower_name = null;
    	$records = MdlApplication::where("id", $application_id)->get();    	
    	if(!empty($records->toArray())) {    		    		
    		$record = $records->toArray();
    		$borrower_name = $record[0]['borrower_name'];
    		if(!empty($borrower_name)) {
    			$lastname = null;
    			$middlename = null;
    			$spltName = explode(",", $borrower_name);
    			if(count($spltName) > 1) {
    				$lastname = trim($spltName[0]);
    				// VASQUEZ, JUAN PAULO DE LEON 
    				$spltFirstname = explode(" ", trim($spltName[1]));
    				$cnt = count($spltFirstname);
    				if($cnt >= 3) {
    					$middlename = trim($spltFirstname[$cnt - 2]) ." ". trim($spltFirstname[$cnt - 1]);
    				} else {
    					$middlename = $spltFirstname[1];
    				}    						
    			}
    			
    			//echo "Lastname: ". $lastname ."<br>";
    			//echo "Middlename: ". $middlename. "<br>";
    			
    			if(!empty($lastname) && !empty($middlename)) {
    				$comelec = MdlComelec::where('voters_name', 'LIKE', $lastname.'%')
    								->where('voters_name', 'LIKE', '%'.$middlename)->get();
    				//dd($comelec->toArray());
    				$output['records'] = $comelec->toArray();
    				$output['total'] = count($comelec->toArray());
    			}
    		}
    	}
    	
    	$output['borrower_name'] = $borrower_name;
    	echo json_encode($output);
    }
    
	private function pushData($results, $arrRecordId, $data) {
		foreach($data as $res) {
			
			if(in_array($res['id'], $arrRecordId)) {
				array_push($this->DUPLICATE_ID, $res['id']);
			}
			
			array_push($results, $res);
			array_push($arrRecordId, $res['id']);
		}

		return[
			$results,
			$arrRecordId
		];
	}

	private function getRules() {
		return [
			'branch' => 'required',
			'borrower_name' => 'required|unique:tbl_application,borrower_name'
		];
	}
}

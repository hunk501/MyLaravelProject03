<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\MdlApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EncodeApplication extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('errors.not_found');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('account.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$inputs = Input::all();
		
		$validator = Validator::make($inputs, $this->getRules());
		if($validator->fails()) {
			Session::flash("error", "Please check form below.");
			return redirect('encode/create')->withErrors($validator)->withInput($inputs);
		} else {
			
			unset($inputs['_token']);
			unset($inputs['submit_form']);

			foreach($inputs as $key => $value) {
				$inputs[$key] = strtoupper($value);
			}
			
			
			MdlApplication::create($inputs);
			
			Session::flash("success", "Record has been saved.");
			return redirect('encode/create');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$check = MdlApplication::where('id', $id)->first();
		if(!empty($check)) {
			//dd($check->toArray());
			return view('account.edit')->with(['records' => $check->toArray()]);
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
	public function update($id)
	{
		$inputs = Input::all();
		$validator = Validator::make($inputs, ['borrower_name' => 'required','branch' => 'required']);
		if($validator->fails()) {
			Session::flash("error", "Please check form below.");
			return redirect('encode/'.$id.'/edit')->withErrors($validator)->withInputs($inputs);
		} else {
			unset($inputs['_method']);
			unset($inputs['_token']);
			unset($inputs['submit_form']);
			
			foreach($inputs as $key => $value) {
				$inputs[$key] = strtoupper($value);
			}
			
			MdlApplication::where('id', $id)->update($inputs);
			
			Session::flash("success", "Record has been updated.");
			return redirect('encode/'. $id .'/edit');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function getRules() {
		return [
			'branch' => 'required',
			'borrower_name' => 'required|unique:tbl_application,borrower_name'
		];
	}

}

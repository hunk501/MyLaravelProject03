<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\MdlPolicy;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Redirect;

class Policy extends Controller {
	
	
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
		$records = MdlPolicy::all();
                
		return view('account.policy_lists')->with( ['records'=>$records] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('account.policy_create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $input)
	{
            /*
            $this->validate($input, [
                            'product_name' => 'required',
                            'product_price' => 'required',
                            'product_qty' => 'required'
            ]);
            */
            /*
            $rules = array(
                'name' => 'required',
                'age'  => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if($validator->fails()) {
                return Redirect::to('policy/create')
                        ->withErrors($validator)
                        ->withInput(Input::except('password'));
            } else {
                $policy = new MdlPolicy();
                $policy->policy_no = Input::get('policy_no');
                $policy->date_from = Input::get('date_from');
                $policy->date_to = Input::get('date_to');
                $policy->save();
                
                Session::flash("success", "Success Message");
		return redirect("policy");
            }
            */
            
            $data = $input->all();
            unset($data['_token']);
            unset($data['submit']);

            MdlPolicy::create($data);

            Session::flash("success", "Success Message");
            return redirect("policy");
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
            $results = MdlPolicy::findOrFail($id)->toArray();
            
            return view('account.policy_edit')->with([ 'records'=>$results ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $policy = MdlPolicy::find($id);
            $policy->firstname = Input::get('firstname');
            $policy->middlename = Input::get('middlename');
            $policy->lastname = Input::get('lastname');
            $policy->vehicle_type = Input::get('vehicle_type');
            $policy->save();
            
            Session::flash("success", "Record has been updated.");
            return redirect("policy");
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

}

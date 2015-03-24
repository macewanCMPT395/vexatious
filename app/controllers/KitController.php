<?php

class KitController extends \BaseController {
	protected $fields = ['type', 'currentBranchID', 'barcode', 'description']; 
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$response = ["status" => "1"];
		$kits = DB::table('kit')->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
					->join('branch', 'currentBranchID', '=', 'branch.id') 
					->get(['kit.id', 'kit.description', 'barcode', 'hardwareType.name', 'identifier']);
		if ($kits) {
			$response = array(
				'status' => 0,
				'kits' =>  $kits
			);		
		}
        
        //Pass kits to view
        return View::make('kits/index')->with('kits', $kits);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only($this->fields);
		$kit = new Kit;
		$kit->fill($input);
		$kit->save();
		return Response::json($kit);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 *
	 * Displays a kit with all the associated hardware
	 *
	 */
	public function show($id)
	{
		$response = ["status" => "1"];
		
		
		$kit = DB::table('kit')->where('kit.id', '=', $id)
						->join('kithardware', 'kithardware.kitID', '=', $id)
						->join('hardware', 'kithardware.hardwareID', '=', 'hardware.id')
						->join('hardwareType', 'hardware.hardwareTypeID', '=', 'hardwareType.id')
						->get();
        
        //Pass kits to view
		return View::make('browsekits' ,compact('kits'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$kit = Kit::find($id);
		$response = ["status" => "1"];
		if ($kit != null) {
			$response = ["status" => "0", "kit"=> $kit];
			$input = array_filter(Input::only($this->fields));
			$kit->fill($input);
			
			echo($kit);
			
			$kit->save();

		}
		
		return Response::json($response);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Auth::user();
		if (!$user || !$user->isAdmin()) return Redirect::back();
		$kit::find($id);
		if($kit) $kit->destroy();
		
		return Response::json(["status" => "0"]);
	}


}

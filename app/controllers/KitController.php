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
		//return View::make('kits.index');
		$kits = Kit::all();
		$response = array(
			'status' => 0,
			'kits' =>  $kits
		);
		
		return Response::json($response);
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
	 */
	public function show($id)
	{
		$kit = Kit::find($id);
		$response = ["status" => "1"];
		if ($kit != null) {
			$response = ["status" => "0", "kit" => $kit];
		}
		
		
		return Response::json($response);
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

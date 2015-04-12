<?php

class KitController extends \BaseController {
	protected $fields = ['type', 'currentBranchID', 'barcode', 'description']; 
	
    public function __construct()
    {
        $this->beforeFilter('auth');
    }	
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
					->get(['kit.id', 'kit.description', 'barcode', 'hardwareType.name', 'identifier', 'currentBranchID', 'type']);
		
		$damagedStatus = DB::table('kit')->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
							->join("kithardware", 'kithardware.kitID', '=', 'kit.id')
							->join("hardware", "hardware.id", '=', 'kithardware.hardwareID')
							->whereNotNull('hardware.damaged')
							->groupBy('kit.id')
							->get(['kit.id']);
		
		//return Response::json($damagedStatus);
		if ($kits) {
			$response = array(
				'status' => 0,
				'kits' =>  $kits
			);		
		}
        
        //Pass kits to view
        return View::make('kits/index')->with('kits', $kits)->with('kitDamage', $damagedStatus);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('kits/create');
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
						->leftJoin('kithardware', 'kithardware.kitID', '=', $id)
						->leftJoin('hardware', 'kithardware.hardwareID', '=', 'hardware.id')
						->leftJoin('hardwareType', 'hardware.hardwareTypeID', '=', 'hardwareType.id')
						->first(['kit.id', 'kit.barcode', 'kit.currentBranchID', 'kit.description', 'kit.type']);
        
		$devices = DB::table('kithardware')->join('hardware', 'kithardware.hardwareID', '=', 'hardware.id')
			   	->join('hardwareType', 'hardware.hardwareTypeID', '=', 'hardwareType.id')
				->where('kithardware.kitID', '=', $id) 
				->get(['hardware.id', 'hardware.damaged', 'assetTag', 'description','name']);
		
		$device = [];
		
		if (count($devices) > 0) {
		
			$device = Hardware::where('hardware.id', '=', $id)
									->join('hardwareType', 'hardware.hardwareTypeID', '=', 'hardwareType.id')
									->leftJoin('kithardware', 'hardware.id', '=', 'kithardware.hardwareID')
									->leftJoin('kit', 'kithardware.kitID', '=', 'kit.id')
									->first(['hardware.id', 'assetTag', 'damaged', 'hardwareType.name',
													 'hardwareType.description', 'kit.id as kitID', 'kit.barcode']);
		}
		//return Response::json([$kit, $devices]);
        //Pass kits to view
		return View::make('kits.edit')->with('kits', $kit)->with('devices', $devices)
				->with('hardware', $device);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		
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
		if (!Auth::user()->isAdmin()) return Redirect::back();
		$kit::find($id);
		if($kit) $kit->destroy();
		
		return Response::json(["status" => "0"]);
	}


}

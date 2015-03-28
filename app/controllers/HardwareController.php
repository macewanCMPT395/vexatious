<?php
/**
Controller for view, editing and creating new 
devices for kits.

When creating a new device, should be able to 
	1. add multiple pieces of software to the device
	2. add the hardware type to the hardware
	

**/
class HardwareController extends \BaseController {
	protected $fields = ['type', 'assetTag', 'damaged'];
	
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
		$devices = Hardware::all();
		//return View::make('devices.index', ['devices' => devices]);
		$response = array(
			'status' => 0,
			'devices' =>  $devices
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

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (!Auth::user()->isAdmin()) return Redirect::back();
		
		//add a new device
        $device = new Hardware;
		$input = array_filter(Input::only($this->fields));
		$device->fill($input);	
        $device->save();

		$response = array(
			'status' => 0,
			'devices' => $device
		);
		return Response::json($response);     
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$device = Hardware::where('hardware.id', '=', $id)
				->join('hardwareType', 'hardware.hardwareTypeID', '=', 'hardwareType.id')
				->leftJoin('kithardware', 'hardware.id', '=', 'kithardware.hardwareID')
				->leftJoin('kit', 'kithardware.kitID', '=', 'kit.id')
				->first(['hardware.id', 'assetTag', 'damaged', 'hardwareType.name', 
						 'hardwareType.description', 'kit.id as kitID', 'kit.barcode']);
		//return Response::json($device);
		return View::make('hardware/show')->with('hardware', $device);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (!Auth::user()->isAdmin()) return Redirect::back();

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//$user = Auth::user();
		//if (!$user || !$user->isAdmin()) return Redirect::back();
		
		//$response = ["status" => "1"];
		$device = Hardware::find($id);
		if($device) {
			//$input = array_filter(Input::only($this->fields));
			//$device->fill($input);
			$clearDamage = Input::get('clear');
			if($clearDamage) {
				$device->damaged = null;
			} else {
				$newDamage = trim(Input::get('damaged'));
				
				if ($device->damaged == null) $device->damaged = $newDamage;
				else {
					$device->damaged = $device->damaged."\n".$newDamage;	
				}
			}
			
			
			
			
			$device->save();
			//$response = ["status" => "0", "device" => $device];
		}
		//return Response::json($response);
		return Redirect::route('hardware.show', ['id'=>$id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//$user = Auth::user();
		//if (!$user || !$user->isAdmin()) return Redirect::back();
		
		$device = Hardware::find($id);
		
		if($device) $device->delete();
		
		return Redirect::route('hardware.index');
	}


}

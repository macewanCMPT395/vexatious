<?php
/**
Controller for view, editing and creating new 
devices for kits.

When creating a new device, should be able to 
	1. add multiple pieces of software to the device
	2. add the hardware type to the hardware
	

**/
class HardwareController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$devices = Hardware::all();
		//return View::make('devices.index', ['devices' => devices]);
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
		//add a new device
        $device = new Hardware;
        $device->hardwareTypeID = Input::get('Type');
        $device->barcode = Input::get('Barcode');
		$device->damaged = "";
		
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
		//
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

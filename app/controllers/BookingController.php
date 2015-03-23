<?php

class BookingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$response = ["status" => "1"];
		
		
		$bookings = DB::table('booking')->join('allBookings', 'allBookings.bookingID', '=', 'booking.id')
						->join('users', 'allBookings.userID', '=', 'users.id')
						->join('kit', 'booking.kitID', '=', 'kit.id')
						->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
						->get();
		
		if ($bookings) {
			//unset($bookings->password);
			foreach ($bookings as &$book) {
				unset($book->password);
				unset($book->email);
			}
			$response = ["status" => "0", "bookings" => $bookings];
			
		}
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
		//
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

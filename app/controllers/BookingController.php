<?php

class BookingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getBookings() {
        $bookings = ["status" => "1"];
		
		$allBookings = DB::table('booking')->join('allBookings', 'allBookings.bookingID', '=', 'booking.id')
						->join('users', 'allBookings.userID', '=', 'users.id')
						->join('kit', 'booking.kitID', '=', 'kit.id')
						->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
						->get();
		

		if ($allBookings) {
			//unset($bookings->password);
			foreach ($allBookings as &$book) {
				unset($book->password);
				unset($book->email);
			}
			$bookings = ["status" => "0", "bookings" => $allBookings];
			
		}
        
        return $bookings;
    }
        
	public function index()
	{
        $bookings = $this->getBookings();
		return View::make('bookings/index' ,compact('bookings'));
	}
    
    public function shipping()
	{
        $kits = $this->getBookings();
		return View::make('bookings/shipping' ,compact('kits'));
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
		$response = ["status" => "1"];
		
		
		$bookings = DB::table('booking')->where('booking.id', '=', $id)
						->join('allBookings', 'allBookings.bookingID', '=', $id)
						->join('users', 'allBookings.userID', '=', 'users.id')
						->join('kit', 'booking.kitID', '=', 'kit.id')
						->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
						->get();
		
		if ($bookings) {
			foreach ($bookings as &$book) {
				unset($book->password);
				unset($book->email);
			}
			$response = ["status" => "0", "bookings" => $bookings];
			
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

	
	
	public function kitAvailability($type, $startDate, $endDate) {
		$start = strtotime($startDate);
		$end = strtotime($endDate);
		
		//return Response::json(['start date' => $start, 'end date' => $end]);
		$this->tempType = $type; //wat
		
		$availability = DB::table('booking')
				->whereBetween('start', [$start,$end])
				->orWhereBetween('end', [$start, $end])
				->join('kit', function($join){
					$join->on('booking.kitID', '=', 'kit.id')
						  ->on('kit.type', '=', $this->tempType);
				
				})
				->join('hardwareType', 'hardwareType.id', '=', $type)
				->groupby('kitID')
				->get(['start',DB::raw('count(*) as count')]);

		return //Response::json($availability);
		       dd($availability);
	}

}

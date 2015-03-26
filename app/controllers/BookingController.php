<?php

class BookingController extends \BaseController {
	protected $bookingFields = ['eventName', 'start', 'end', 'destination','shipping', 
								'kitID', 'shipped', 'received'];
	

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
						->join('branch', 'branch.id', '=', 'booking.destination')
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
		return View::make('bookings/index')->with('bookings', $bookings);
	}
    
    public function shipping()
	{
        $bookings = $this->getBookings();
        
		return View::make('bookings/shipping' ,compact('bookings'));
	}
    
    public function receiving()
	{
        $bookings = $this->getBookings();
        
		return View::make('bookings/receiving' ,compact('bookings'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('bookings/bookkit');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = array_filter(Input::only($this->bookingFields));
		//return Response::json($input);
		//create the actual booking
		$booking = new Booking;
		$booking->fill($input);
		$booking->shipping = 0;
		$booking->shipped = false;
		$booking->received = false;
		$booking->save();
	
		$userID = Input::get('userID');
		//now link the booking with a user
		UserBookings::create(array(
			"userID" => $userID,
			"bookingID" => $booking->id
		));
		
		//create notifications for the user
		//notifications will need to be joined with the 
		//bookings table to get the proper dates
		//first notification for receiving
		UserNotifications::create(array(
			"userID" => $userID,
			"bookingID" => $booking->id,
			"msgID" => 1
		));
		//second notification for shipping
		UserNotifications::create(array(
			"userID" => $userID,
			"bookingID" => $booking->id,
			"msgID" => 2
		));	
		
		
		return Response::json($booking);
		
		
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
     * @input form with fields id, shipped, received
	 * @param  
	 * @return Response
	 */
	public function update()
	{
        $booking = Booking::find(Input::get('id'));
        $booking->shipped = Input::get('shipped');
        $booking->received = Input::get('received');
        $booking->save();
        
        if (Input::get('form') == "ship")
            return Redirect::route('shipping');
        else
            return Redirect::route('receiving');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//remove booking from all bookings
		DB::table('allBookings')->where('bookingID', '=', $id)->delete();
		//remove notifications from bookings
		DB::table('notifications')->where('bookingID', '=', $id)->delete();
		//then remove the booking itself
		Booking::find($id)->delete();
		
		return Redirect::route('/');
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
		
		$total = DB::table('kit')->count();//get total number of kits for specific type
		$total = $total * 3;		
		return Response::json(['available'=>$availability,'count'=>$total]);
	}

}

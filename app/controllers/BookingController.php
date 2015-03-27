<?php

class BookingController extends \BaseController {
	protected $bookingFields = ['eventName', 'start', 'end', 'destination'];
	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getBookings() {
        $bookings = ["status" => "1", "bookings"=> []];
		
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


	
	public function createBookingTime($start, $end, $buffers) {
		
		$newStart =  DateTime::createFromFormat('Y-m-d', $start);
		$newEnd = DateTime::createFromFormat('Y-m-d', $end);
		
		
		if(!$buffers) return [$newStart, $newEnd];
		
		//first, subtract a day from start date, and add a day to end date
		$newStart->modify('-1 day');
		$newEnd->modify('+1 day');
	
		//get the day of week
		$startDOW = $newStart->format('w');
		$endDOW = $newEnd->format('w');
		//user booked for monday, but receive day is sunday
		//make receive day the previous friday
		if($startDOW == 0) {
			$newStart->modify('-2 day');
		} else if ($startDOW == 6) {
			
			//well they can't book on a saturday	
			//so bump it down to friday?
			$newStart->modify('-1 day');
		}
		
		//users booking ended friday, but there is a day after
		//for shipping, so bump the shipping day to the following
		//monday
		if($endDOW == 6) {
			$newEnd->modify('+2 day');	
		} else if ($endDOW == 0) {
			//can't end a booking on sunday, 
			//just bump it to monday
			$newEnd->modify('+1 day');
		}
		
		
		//right, booking dates should be good now
		return [$newStart, $newEnd];
	}
	
	public function bookingToUnix($time) {
		return [ mktime(23, 59, 59, $time[0]->format('m'), $time[0]->format('d'), $time[0]->format('Y')),
				 mktime(23,59,59,$time[1]->format('m'), $time[1]->format('d'), $time[1]->format('Y'))];
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(!Auth::check()) return Redirect::back();
		
		$kitCode = Input::get('kitCode');
		$input = array_filter(Input::only($this->bookingFields));
		//return Response::json($input);
		//create the actual booking
		$booking = new Booking;
		$booking->fill($input);
		
		//actual booking dates
		$bookingDates = $this->createBookingTime(Input::get('start'), Input::get('end'), false);
		$bookTimes = $this->bookingToUnix($bookingDates);
		$booking->start = $bookTimes[0];
		$booking->end = $bookTimes[1];
		
		
		
		//then factor in shipping and receiving dates
		$bookingDates = $this->createBookingTime(Input::get('start'), Input::get('end'), true);
		$bookTimes = $this->bookingToUnix($bookingDates);
		$booking->receiving = $bookTimes[0];
		$booking->shipping = $bookTimes[1];
		
		$kit = Kit::where('barcode', $kitCode)->first();
		$booking->kitID = $kit->id;
		$booking->shipped = false;
		$booking->received = false;
		$booking->save();
	
		$userID = Auth::user()->id;
			//Input::get('userID');
		//now link the booking with a user
		UserBookings::create(array(
			"userID" => $userID,
			"bookingID" => $booking->id,
			"creator"=> "1"
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
		
		
		return Redirect::route('bookings.index');
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
        if (Input::get('id') != "") {
            $booking = Booking::find(Input::get('id'));
            $booking->shipped = Input::get('shipped');
            $booking->received = Input::get('received');
            $booking->save();
        }
        
        if (Input::get('form') == "ship")
            return Redirect::route('shipping');
        else {
            if (Input::get('id') != "") {
                $kit = Kit::find(Input::get('kitID'));
                $kit->currentBranchID = Input::get('destination');
                $kit->save();
            }
            return Redirect::route('receiving'); 
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
		//remove booking from all bookings
		DB::table('allBookings')->where('bookingID', '=', $id)->delete();
		//remove notifications from bookings
		DB::table('notifications')->where('bookingID', '=', $id)->delete();
		//then remove the booking itself
		Booking::find($id)->delete();
		
		return Redirect::route('/');
	}
	
	public function getKitForDate($type, $startDate, $endDate) {
		$response = ["status"=> "1"];
		
		$this->tempType = $type; //wat
		
		//first, try and find a kit that has yet to be booked yet
		$free = DB::table('kit')->leftJoin('booking', 'kit.id','=', 'booking.kitID')
				->where('kit.type', '=', $this->tempType)
				->whereNull('booking.id')->get(['kit.id', 'kit.barcode', 'kit.description']);
		
		
	
		//then, search all the kits that do have bookings, but are free for this period
		$bookingDates = $this->createBookingTime($startDate, $endDate, true);
		$bookingDates = $this->bookingToUnix($bookingDates);
		$this->start = $bookingDates[0];
		$this->end = $bookingDates[1];

		$freeBooked = DB::table('booking')
				->where(function($q) {
					$q->where('receiving', '<', $this->start)->where('shipping', '<', $this->start);
				})
				->orWhere(function($q) {
					$q->where('receiving', '>', $this->end)->where('shipping', '>', $this->end);	
				})
				->join('kit', function($join){
					$join->on('booking.kitID', '=', 'kit.id')
						  ->on('kit.type', '=', $this->tempType);
				})
				->join('hardwareType', 'hardwareType.id', '=', $this->tempType)->distinct()
				->get(['kit.id', 'kit.barcode', 'kit.description']);
		
		//return dd(DB::getQueryLog());
		
		//merge both responses and return them
		$available = array_merge($free, $freeBooked);
		if(count($available) > 0) {
			$response = ["status"=>"0", "available"=>$available];	
		}
		
		return Response::json($response);
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

<?php

/*
	booking->start: the date in which the booking event starts
	booking->end: the last date for the booking event

	booking->receiving: the date in which a branch will receive a booking 
		booking->start -1 in most cases, unless that booking is for a monday,
		booking->receiving will attempt to be set for the previous friday
		if available
		
	booking->shipping: the date in which a branch must ship out their kit
		this date isn't set unless there is another booking for this kit,
		in that case, it will be set to the receiving date for the next booking.
		Minimum of booking->end + 1
*/

use Illuminate\Support\MessageBag;

class BookingController extends \BaseController {
	protected $bookingFields = ['eventName', 'start', 'end', 'destination'];
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getBookings() {
        $bookings = ["status" => "1", "bookings"=> [], "creators" => []];
		
		//users associated with a booking will have to be listed in
		//a more detail view for bookings, otherwise we'll get multiple bookings
		//for each user involved in one booking
		$allBookings = DB::table('booking')
						->join('kit', 'booking.kitID', '=', 'kit.id')
						->join('hardwareType', 'hardwareType.id', '=', 'kit.type')
						->join('branch', 'branch.id', '=', 'booking.destination')
						->get(['booking.id as bookingID', 'eventName','branch.name', 'start', 'end', 
							   'hardwareType.name as hname','kit.type', 'branch.id',
							  'destination', 'kit.barcode']);
		
		$bookingCreators = DB::table('allBookings')
							->join('users', 'allBookings.userID', '=', 'users.id')
							->where('allBookings.creator', '>', '0')
							->get(['allBookings.bookingID', 'users.firstName', 'users.lastName']);
		if ($allBookings) {
			//unset($bookings->password);
			foreach ($allBookings as &$book) {
				unset($book->password);
				unset($book->email);
			}
			$bookings = ["status" => "0", "bookings" => $allBookings, "creators" => $bookingCreators];
			
		}
        
        return $bookings;
    }
        
	public function index()
	{
        $bookings = $this->getBookings();
		//handle json request types
		if(Request::wantsJson()) {
			if ($bookings)
				return Response::json(["status" => "0", "bookings" => $bookings]);
			return Response::json(["status"=>"1", "bookings"=>[]]);
		}
		return View::make('bookings/index')->with('bookings', $bookings);
				
	}
	
    public function shipping()
	{
        $bookings = $this->getBookings();
 		//handle json request types
		if(Request::wantsJson()) {
			if ($bookings)
				return Response::json(["status" => "0", "bookings" => $bookings]);
			return Response::json(["status"=>"1", "bookings"=>[]]);
		}       
		return View::make('bookings/shipping' ,compact('bookings'));
	}
    
    public function receiving()
	{
        $bookings = $this->getBookings();
 		//handle json request types
		if(Request::wantsJson()) {
			if ($bookings)
				return Response::json(["status" => "0", "bookings" => $bookings]);
			return Response::json(["status"=>"1", "bookings"=>[]]);
		}     
		return View::make('bookings/receiving' ,compact('bookings'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('bookings/bookkit')->with('holidays', Holiday::all());
	}


	
	public function createBookingTime($start, $end, $buffers) {
		
		$newStart =  DateTime::createFromFormat('Y-m-d', $start);
		$newEnd = DateTime::createFromFormat('Y-m-d', $end);
		
		//users booking ended friday, but there is a day after
		//for shipping, so bump the shipping day to the following
		//monday

		
		
		if($buffers) {
			//Get the booking dates including the shipping date
			//first, subtract a day from start date, and add a day to end date
			$newStart->modify('-1 day');
			$newEnd->modify('+1 day');
		}
			//return [$newStart, $newEnd];
		

		
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
		
		$startDate = Input::get('start');
		$endDate = Input::get('end');
		
		//make sure we aren't booking over a holiday
		$holidays = Holiday::lists('date');
		foreach($holidays as $day) {
			if($day == $startDate || $day == $endDate){
				
				$errors = new MessageBag(['holidayError'=>"Bookings are unavailable on holidays."]);
				return Redirect::back()->withErrors($errors)->withInput(Input::all());	
			}
		}
		
		
		$kitCode = Input::get('kitCode');
		$input = array_filter(Input::only($this->bookingFields));
		//return Response::json($input);
		//create the actual booking
		$booking = new Booking;
		$booking->fill($input);
		
		//actual booking dates
		$bookingDates = $this->createBookingTime($startDate, $endDate, false);
		$bookTimes = $this->bookingToUnix($bookingDates);
		$booking->start = $bookTimes[0];
		$booking->end = $bookTimes[1];
		
		//then factor in shipping and receiving dates
		$bookingDates = $this->createBookingTime($startDate, $endDate, true);
		$bookTimes = $this->bookingToUnix($bookingDates);
		//shipping time is set to a date before, as close as possible, to the start
		//of the booking
		$booking->shipping = $bookTimes[0];
		
		$kit = Kit::where('barcode', $kitCode)->first();
		$booking->kitID = $kit->id;
		
		//check if the kit needs to be shipped from homebase first
		/*$noBookings = Kit::leftJoin('booking', 'kit.id', '=', 'booking.kitID')
			->where('kit.id', '=', $kit->id)
			->whereNull('booking.id')->distinct()->get(['kit.id']);
		
		//if the kit wasn't previously booked,
		//set its shipping flag
		if (count($noBookings) > 0)
			$booking->shipped = true;*/
		
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
		
		//handle json request types
		if(Request::wantsJson()) {
			return Response::json(["status" => "0", "booking" => $booking]);
		}		
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
		$response = ["status" => "1", "bookings" => []];
		
		
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
		}

		//handle json request types
		if(Request::wantsJson()) {
			if ($bookings)
				return Response::json(["status" => "0", "bookings" => $bookings]);
			return Response::json(["status"=>"1", "bookings"=>[]]);
		}
		
		return View::make('bookings/show')->with('bookings', $bookings);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->show($id);
	}

	/**
	 * Update the specified resource in storage.
	 * 
     * @input form with fields id, shipped, received
	 * @param  
	 * @return Response
	 */
	public function update($id)
	{
		$booking = Booking::find($id);
		if($booking) {
			$booking->shipped = Input::get('shipped');
			$booking->received = Input::get('received');
			$booking->eventName = Input::get('eventName');
			$booking->save();

			$dest = Input::get('destination');
			if($dest) {
				$kit = Kit::find(Input::get('kitID'));
				if($kit){
					$kit->currentBranchID = $dest;
					$kit->save();
				}
			}
			
			//check for user updates
			$num = 1;
			while(Input::get('hidden_'.$num)) {
				$userID = Input::get('hidden_'.$num);
				UserBookings::create(array(
					"userID" => $userID,
					"bookingID" => $id,
					"creator"=> "0"
				));		
			}
		}
		
		//handle json request types
		if(Request::wantsJson()) {
			if ($booking)
				return Response::json(["status" => "0", "booking" => $booking]);
			return Response::json(["status"=>"1", "booking"=>[]]);
		}
		return Redirect::back();
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
		$response = ["status"=> "1", "available"=>[]];
		
		$this->tempType = $type; //wat
		
		//first, try and find a kit that has yet to be booked yet
		$free = DB::table('kit')->leftJoin('booking', 'kit.id','=', 'booking.kitID')
				->where('kit.type', '=', $this->tempType)
				->whereNull('booking.id')->distinct()->get(['kit.id', 'kit.barcode', 'kit.description']);
		
		
	
		//then, search all the kits that do have bookings, but are free for this period
		$bookingDates = $this->createBookingTime($startDate, $endDate, true);
		$bookingDates = $this->bookingToUnix($bookingDates);
		$this->start = $bookingDates[0];
		$this->end = $bookingDates[1];

		//generate list of currently booked kits in this date range
		$currentlyBooked = DB::table('booking')
				->where(function($q) {
					$q->where('end', '>=', $this->start)->orWhere('shipping', '>=', $this->start);
				})
				->where(function($q) {
					$q->where('end', '<=', $this->end)->orWhere('shipping', '<=', $this->end);	
				})
				->lists('booking.kitID');
		
		//then find one that isn't currentlyBooked
		$freeBooked = DB::table('booking')
				->join('kit', function($join){
					$join->on('booking.kitID', '=', 'kit.id')
						  ->on('kit.type', '=', $this->tempType);
				})
				->join('hardwareType', 'hardwareType.id', '=', $this->tempType)->distinct()
				->whereNotIn('kit.id', $currentlyBooked)
				->get(['kit.id', 'kit.barcode', 'kit.description']);
		
		//merge both responses and return them
		$available = array_merge($free, $freeBooked);
		if(count($available) > 0) {
			$response = ["status"=>"0", "available"=>$available];	
		}
		
		return Response::json($response);
	}
}

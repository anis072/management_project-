<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calender;
use App\Http\Resources\CalendarResource;
class CalenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    $calendar=Calender::where('user_id',Auth()->id())->get();
        return CalendarResource::collection($calendar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[  
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date'  => 'required',
              ]);
              
        $new_calendar = Calender::create([
            'event_name' => $request->event_name,
            'start_date' =>$request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth()->id()
        ]);
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return response($calendar, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $calender= Calender::find($id);
        $calender->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $calender=Calender::find($id);
        $calender->delete();
        
    }
}

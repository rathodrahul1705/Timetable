<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeTable;
use App\subject;
use Auth;

class TimetableController extends Controller
{
    public function Create(){

    	return view('timetable.create');

    }

    public function timetableSave(Request $request){

    	$timeTable = new TimeTable();
    	$timeTable->no_of_working_days = $request->no_of_working_days;	
    	$timeTable->no_of_working_hrs_per_day = $request->no_of_working_hrs_per_day;	
    	$timeTable->total_subject = $request->total_subject;	
    	$timeTable->no_of_subject_per_days = $request->no_of_subject_per_days;	
    	$timeTable->total_hours_for_week = $request->total_hours_for_week;
        $timeTable->user_id = auth()->user()->id;
    	if ($timeTable->save()) {
    		return redirect()->back()->with('success','Total hours auto-genrate succesfully')->with('total_hours_for_week', $request->total_hours_for_week);
    	}

    }

    public function saveSubjects(Request $request){

            $data = $request->all();
            // dd($data);
            $count=0;
            for($i=0; $i<=count($data["subject"])-1;$i++) {

                // dd($value);
                $subject = new subject();
                $subject->subject_name = $data["subject"][$i];
                $subject->subject_hrs = $data["hours"][$i];
                $subject->user_id = auth()->user()->id;

                $subject->save();
                $count+=1;
            }
        if ($count==count($data["subject"])-1) {
            $status["success"] ="success";
        }else{

            $status["failure"] ="success";
        }

        return $status;

    }

    public function getTotalHoursForWeek() {
        $data = TimeTable::select('total_hours_for_week')->where('user_id', Auth::user()->id)->first();
        if ($data) {
            return $data->total_hours_for_week;
        }
        else  
            return false;
    }
    public function timeTableGenerate(){
        $data = TimeTable::select()->where('user_id', auth()->user()->id)->first();
        $total_cols = $data->no_of_working_days;
        $total_rows = $data->no_of_subject_per_days;
        return view('timetable.time_table', compact('total_cols', 'total_rows'));

    }
}

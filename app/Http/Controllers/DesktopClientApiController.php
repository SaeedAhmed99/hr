<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Screenshot;
use App\Models\TimeTracker;
use Illuminate\Http\Request;
use App\Models\EmployeeProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DesktopClientApiController extends Controller
{
    public function dextop_login(Request $request)
    {
        // $user = User::where('email', $request->email)
        //     ->join('employees', 'employees.employee_id', 'users.id')
        //     ->selectRaw('users.*, employees.screenshot_duration')
        //     ->first();
        // if(!isset($user->screenshot_duration)){
        //     $default_screenshot_duration = Setting::where('user_id', Auth::user()->id)->value('screenshot_duration');
        //     $user->screenshot_duration = $default_screenshot_duration;
        // }

        $users = User::where('email', $request->email)->get();
        if(is_null($users[0]->avater)){
            $users[0]->avater = "";
        }

        if (count($users) > 0) {
            $user = User::where('email', $request->email)->first();
            $request_password = $request->password;
            $hashed_password = $user->password;

            if (Hash::check($request_password, $hashed_password)) {
                return json_encode($users);
            } else {
                return json_encode([]);
            }
        } else {
            return json_encode($users);
        }
    }


    public function dextop_projects(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        
        $project_ids = DB::table('employee_project')
            ->where('employee_id', $user->employee->id)
            ->selectRaw('project_id')
            ->get();

        $project_staff_ids_array = [];

        foreach ($project_ids as $id) {
            array_push($project_staff_ids_array, $id->project_id);
        }

        $project_name_with_id = [];
        $projects = Project::whereIn('id', $project_staff_ids_array)->get();
        foreach ($projects as $project) {
            array_push($project_name_with_id, $project->id . "_" . $project->title);
        }

        return json_encode($project_name_with_id);
    }

    public function dextop_time_tracker(Request $request)
    {
        $email = $request->email;
        $project_id = explode("_", $request->project)[0];
        $task_title = $request->task_title;

        $user = User::with('employee')->where('email', $email)->first();
        $project_people = EmployeeProject::where('employee_id', $user->employee->id)->where('project_id', $project_id)->first();
        // $project_id = Project::where('title', $project)->first()->id;

        $time_tracker = new TimeTracker();
        // $time_tracker->project_id = $project_id;
        // $time_tracker->user_id = $user_id;
        $time_tracker->task_title = $task_title;
        $time_tracker->start = date('Y-m-d H:i:s');
        $time_tracker->employee_project_id = $project_people->id;
        $time_tracker->save();

        // $response = array($time_tracker);
        // return json_encode($response);

        return $time_tracker->id;
    }

    public function dextop_screenshot_duration(Request $request)
    {
        $user_id = User::where('email', $request->email)->first()->id;

        $employee = Employee::where([
            'user_id' => $user_id,
        ])->first();

        if (!is_null($employee->screenshot_duration)) {
            $screenshot_duration = $employee->screenshot_duration;
        } else {
            $screenshot_duration = setting('screenshot_duration');
        }

        return $screenshot_duration;
    }

    public function dextop_time_tracker_stop(Request $request)
    {
        $timeTrackerId = $request->timeTrackerId;

        $timeTracker = TimeTracker::findOrFail($timeTrackerId);
        $timeTracker->end = date('Y-m-d H:i:s');
        $timeTracker->save();

        return $timeTracker;
    }

    public function dextop_test_upload(Request $request)
    {
        $email = $request->email;
        $timeTrackerId = $request->timeTrackerId;

        $screenshot = new Screenshot();
        $screenshot->time_tracker_id = $timeTrackerId;
        $screenshot->activity = $request->activity;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();

            //naming file
            $staff_name = User::where('email', $email)->first()->name;
            $single_names = explode(" ", $staff_name);
            $first_name = $single_names[0];
            $first_name = strtolower($first_name);
            $reversed_first_name = strrev($first_name);

            $filename = time() . '_' . $reversed_first_name . '_time_tracker_no_' . $timeTrackerId . '.' . $extention;
            $file->move('captured/', $filename);

            $screenshot->image = $filename;
        }

        $screenshot->keystroke = $request->keystroke;
        $screenshot->mouse_click = $request->mouse_click;
        // $screenshot->mouse_click = rand(10, 97);
        $screenshot->save();

        TimeTracker::where('id', $timeTrackerId)->update([
            'end' => date('Y-m-d H:i:s')
        ]);
    }

    public function dextop_no_ui_upload(Request $request)
    {
        $mac_address = $request->macAddress;
        $employee = Employee::where('mac_address', $mac_address)->first();

        //creting screenshot object
        $screenshot = new Screenshot();
        $screenshot->employee_id = $employee->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();

            //naming file
            $filename = time() . '_' . $mac_address . '.' . $extention;
            $file->move('captured/', $filename);

            $screenshot->image = $filename;
        }

        $screenshot->save();
    }
}

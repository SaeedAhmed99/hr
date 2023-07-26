<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (Auth::user()->can('Manage Holiday')) {
            $weekends = json_decode(setting('weekends'));
            // dd($weekends);
            return view('holiday.index', compact('weekends'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('Create Holiday')) {
            $request->validate([
                'name' => 'required|array',
                'holidate' => 'required|array',
                'duration' => 'required|array',
                'name.*' => 'required',
                'holidate.*' => 'required_with:name.*',
                'duration.*' => 'required_with:name.*|integer|gte:1'
            ]);

            $holidays = [];

            foreach ($request->name as $idx => $name) {
                $holidate = new Carbon($request->holidate[$idx]);
                $end_date = new Carbon($request->holidate[$idx]);
                $end_date->addDays($request->duration[$idx] - 1);
                $holidays[] = [
                    'name' => $name,
                    'holidate' => $holidate,
                    'end_date' => $end_date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Holiday::insert($holidays);
            return response('Successfully Inserted', 201);
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Holiday $holiday)
    {
        $holidate = new Carbon($holiday->holidate);
        $end_date = new Carbon($holiday->end_date);
        $diff = $holidate->diff($end_date);
        $holiday->duration = $diff->d + 1;
        return response()->json($holiday);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Holiday $holiday)
    {
        if (Auth::user()->can('Update Holiday')) {
            $request->validate([
                'name' => 'required',
                'holidate' => 'required',
                'duration' => 'required|integer|gte:1',
            ]);

            $holiday->name = $request->name;
            
            $end_date = new Carbon($request->holidate);
            $end_date->addDays($request->duration - 1);
            $holiday->holidate = $request->holidate;
            $holiday->end_date = $end_date;

            if ($holiday->isDirty()) {
                $holiday->save();
            }

            return response('Successfully updated', 200);
        } else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Holiday $holiday)
    {
        if (Auth::user()->can('Delete Holiday')) {
            $holiday->delete();
            return response('Successfully deleted!', 200);
        } else {
            abort(401);
        }
    }

    public function data(Request $request)
    {
        $holidays = Holiday::whereYear('holidate', $request->year)->get();
        return view("components.holidays")->with("holidays", $holidays);
    }

    public function weekendUpdate(Request $request)
    {
        $request->validate([
            'weekend' => 'required'
        ]);

        if (Auth::user()->can('Update Holiday')) {
            Setting::where('name', 'weekends')->update([
                'value' => json_encode($request->weekend)
            ]);
            return response("Successfully updated", 200);
        } else {
            abort(401);
        }
    }
}

<?php

namespace App\Http\Controllers;

use DateTimeZone;
use App\Models\Setting;
use App\Mail\SettingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('Manage System')) {
            $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            return view('setting.index', compact('timezonelist'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function saveBusinessSettings(Request $request)
    {
        if (Auth::user()->can('Manage System')) {
            $user = Auth::user();
            if ($request->company_logo) {
                $request->validate([
                    'company_logo' => 'image|mimes:png|max:20480',
                ]);

                $logoName = 'logo.png';
                $path = $request->file('company_logo')->move(public_path('storage/logo'), $logoName);
                $full_path = 'storage/logo/' . $logoName;
                //dd($full_path);
                $setting = Setting::where('name', '=', 'company_logo')->first();
                $setting->value = $full_path;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }

            if ($request->company_favicon) {
                $request->validate([
                    'company_favicon' => 'image|mimes:png|max:20480',
                ]);
                $favicon = 'favicon.png';
                $path = $request->file('company_favicon')->move(public_path('storage/logo'), $favicon);
                $full_path = 'storage/logo/' . $favicon;
                // $path = $request->file('company_favicon')->storeAs('logo', $favicon, 'public');
                // $full_path = 'storage/' . $path;
                //dd($full_path);
                $setting = Setting::where('name', '=', 'company_favicon')->first();
                $setting->value = $full_path;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->company_title) {
                $request->validate([
                    'company_title' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'company_title')->first();
                $setting->value = $request->company_title;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->footer_text) {
                $request->validate([
                    'footer_text' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'footer_text')->first();
                $setting->value = $request->footer_text;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->meta_keyword) {
                $request->validate([
                    'meta_keyword' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'meta_keyword')->first();
                $setting->value = $request->meta_keyword;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->meta_desc) {
                $request->validate([
                    'meta_desc' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'meta_desc')->first();
                $setting->value = $request->meta_desc;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->ip_restrict == null) {
                $setting = Setting::where('name', '=', 'ip_restrict')->first();
                $setting->value = 'off';
                if ($setting->isDirty()) {
                    $setting->save();
                }
            } else {
                $request->validate([
                    'ip_restrict' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'ip_restrict')->first();
                $setting->value = $request->ip_restrict;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }


            if ($request->company_start_time) {

                $company_time = [
                    'start_time' => $request->company_start_time,
                    'duration' => $request->duration,
                ];
                $request->validate([
                    'company_start_time' => 'required',
                    'duration' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'company_start_time')->first();
                $setting->value = json_encode($company_time);
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }

            if ($request->timezone) {
                $request->validate([
                    'timezone' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'timezone')->first();
                $setting->value = $request->timezone;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            if ($request->website_title) {
                $request->validate([
                    'website_title' => 'required',
                ]);

                $setting = Setting::where('name', '=', 'website_title')->first();
                $setting->value = $request->website_title;
                if ($setting->isDirty()) {
                    $setting->save();
                }
            }
            // $mailData = [
            //     'title' => 'Using Domain ',
            //     'body' => $_SERVER['SERVER_NAME'],
            // ];

            // Mail::to('cctl.products@gmail.com')->send(new SettingMail($mailData));

            return redirect()
                ->back()
                ->with('success', 'Setting successfully updated.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Permission denied.');
        }
    }
}

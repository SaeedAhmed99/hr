<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstallController extends Controller
{
    public function requirements()
    {
        Artisan::call('optimize:clear');
        $permission['curl_enabled']           = function_exists('curl_version');
        $permission['db_file_write_perm']     = is_writable(base_path('.env'));
        return view('install.requirements', compact('permission'));
    }

    public function verifyCode($code)
    {
        # code...
    }

    public function showServerConfig()
    {
        Artisan::call('optimize:clear');
        return view('install.server-config');
    }

    public function createServerConfig(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_encryption' => 'required',
        ]);

        $this->writeEnvironmentFile('DB_HOST', $request->db_host);
        $this->writeEnvironmentFile('DB_PORT', $request->db_port);
        $this->writeEnvironmentFile('DB_DATABASE', $request->db_database);
        $this->writeEnvironmentFile('DB_USERNAME', $request->db_username);
        $this->writeEnvironmentFile('DB_PASSWORD', $request->db_password);

        if (!empty($request->mail_host)) {

            $this->writeEnvironmentFile('MAIL_HOST', $request->mail_host);
            $this->writeEnvironmentFile('MAIL_PORT', $request->mail_port);
            $this->writeEnvironmentFile('MAIL_USERNAME', $request->mail_username);
            $this->writeEnvironmentFile('MAIL_PASSWORD', $request->mail_password);
            $this->writeEnvironmentFile('MAIL_ENCRYPTION', $request->mail_encryption);
            $this->writeEnvironmentFile('MAIL_FROM_ADDRESS', $request->mail_from_address);
        }
        
        Artisan::call('optimize:clear');
        return redirect(route('install.server.migrate'));
    }

    public function dbMigration()
    {
        if(!$this->check_database_connection(env('DB_HOST'), env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'))) {
            return back()->with(['message' => 'Database credentials wrong!']);
        }
        
        Artisan::call('key:generate');
        Artisan::call('storage:link');
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');

        $oldWeb = base_path('routes/web.php');
        $newWeb = base_path('routes/web.txt');
        copy($newWeb, $oldWeb);
        return redirect('/');
    }

    public function writeEnvironmentFile($type, $val)
    {
        $path = base_path('.env');
        // dd($type.'="'.env($type).'"', $type.'='.$val,file_get_contents($path));
        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            file_put_contents($path, str_replace(
                $type . '="' . env($type) . '"',
                $type . '=' . $val,
                file_get_contents($path)
            ));
        }
    }

    public function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "") {

        if(@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        }else {
            return false;
        }
    }
}

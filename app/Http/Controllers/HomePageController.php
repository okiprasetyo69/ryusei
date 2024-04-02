<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

use App\Imports\TestImport;

class HomePageController extends Controller
{
    public function dashboard(){
        return view("dashboard.index");
    }

    public function getDataGSheet(Request $request){
        $client = new Client();
        $response = $client->request('GET', 'https://sheets.googleapis.com/v4/spreadsheets/1SnDcLvQGb4ZJGrkNApgFdUTZbtyZJ8NfVmW5ZpNeE_A');
        $body = $response->getBody();
        $data = json_decode($body, true);
        dd($data);
        return $data;

    }
}

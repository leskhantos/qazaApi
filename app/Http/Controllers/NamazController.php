<?php


namespace App\Http\Controllers;


use App\Namaz;
use Illuminate\Http\Request;

class NamazController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register']]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'fajr' => 'required',
            'dhuhr' => 'required',
            'asr' => 'required',
            'maghrib' => 'required',
            'isha' => 'required',
        ]);
        $namaz = Namaz::create([
           'fajr' => request('fajr'),
           'dhuhr' => request('dhuhr'),
           'asr' => request('asr'),
           'maghrib' => request('maghrib'),
           'isha' => request('isha'),
           'user_id' => auth()->id()
       ]);

        return response()->json(['msg'=>$namaz]);
    }
    public function show(Namaz $namaz)
    {
        return response()->json(['namaz'=>$namaz]);
    }
    public function update(Request $request, Namaz $namaz)
    {
        $request->validate([
            'fajr' => 'required',
            'ghuhr' => 'required',
            'asr' => 'required',
            'maghrib' => 'required',
            'isha' => 'required',
        ]);

        $namaz->update($request->all());

        return response()->json(['msg'=>'updated successfully',
                                    'namaz'=>$namaz]);
    }
    public function destroy(Namaz $namaz)
    {
        $namaz->delete();

        return response()->json(['msg'=>'deleted successfully',
            'namaz'=>$namaz]);
    }
}

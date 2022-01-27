<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function json()
    {
        $data = User::where('isAdmin',0)->get();
        return DataTables::of($data)->addColumn('action', function ($data) {
        return '
        <a href="'.route('user.edit',$data->id).'"  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <a href="'.route('user.delete',$data->id).'" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
        
        <a href="'.route('user.elimination',$data->id).'" class="btn btn-sm btn-primary"><i class="fa fa-times"></i> Eliminasi Peserta</a>
        
        ';
        })->addIndexColumn()->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'unique:users',
            'password' => 'confirmed'
        ]);
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ];
        User::create($data);
        return redirect()->route('user.index')->with('success','Berhasil !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
        ];
        if(!empty($request->password)) {
            $request->validate([
                'password' => 'confirmed'
            ]);
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('user.index')->with('success','Berhasil !');
    }
    
    public function elimination(User $user) {
        $user->update([
            'is_elimination' => 1
        ]);
        return redirect()->back()->with('success','Peserta berhasil di eliminasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
        if($user->akses_kuis()->exists()) $user->akses_kuis()->delete();
        if($user->event_submit()->exists()) $user->event_submit()->delete();
        if($user->kuis_submit()->exists()) $user->kuis_submit()->delete();
        
    
        $user->delete();
        return redirect()->route('user.index')->with('success','Berhasil !');
    }
}

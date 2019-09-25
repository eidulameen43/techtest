<?php

namespace App\Http\Controllers;

use App\User;
// use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Redirect,Response;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = User::all();

        return view('users.index', compact('users'));
        // return Datatables::of(User::query())->make(true);
        

        
    }

    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       return view('users.create');
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
        $request->validate([
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|max:255',
            'password_confirm'=>'required|max:255',
            'status'=>'required|digits:1'
        ]);

        if($request->password == $request->password_confirm){
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->save();
            return redirect('/users')->with('success', 'New user data added!!');
        } else {
            return redirect('/users/create')->with('fail', 'Password and confirm password not same!!')->withInput();
        }
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
        $user = User::find($id);
        return view('users.edit', compact('user'));
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
        // $request->validate([
            // 'first_name'=>'required|max:255',
            // 'last_name'=>'required|max:255',
            // 'email'=>'required|email',
            // 'password'=>'required|max:255',
            // 'password_confirm'=>'required|max:255',
            // 'status'=>'required|digits:1'
        // ]);

        $validator = Validator::make($request->all(), [
            // 'title' => 'required|unique:posts|max:255',
            // 'body' => 'required',
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'email'=>'required|email',
            'password'=>'required|max:255',
            'password_confirm'=>'required|max:255',
            'status'=>'required|digits:1'
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.show', ['id' => $id])
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->password == $request->password_confirm){
            $user = User::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            // $user->save();
            
            try { 

                $user->save();
                return redirect('/users')->with('success', 'User data updated!!');
                
              } catch(QueryException $ex){

                return redirect()->route('users.show', ['id' => $id])->with('fail', 'The email already taken!!')->withInput();

              }

            
        } else {
            return redirect()->route('users.show', ['id' => $id])->with('fail', 'Password with confirm password not same!!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User has been deleted!!');
    }
}

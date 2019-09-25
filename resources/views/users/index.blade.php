@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a href="{{ route('users.create') }}" class="btn btn-success m-3">Add New User</a>
            <div class="card">
                <div class="card-header">User Management</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th><strong>Id</strong></th>
                                <th><strong>First Name</strong></th>
                                <th><strong>Last Name</strong></th>
                                <th><strong>Email</strong></th>
                                <th><strong>Status</strong></th>
                                <th><strong>Action</strong></th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>    
                                <td>{{$user->id}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>

                                <td>
                                @php
                                    if($user->status == 1){
                                        echo "Active";
                                    }else {
                                        echo "Inactive";
                                    }
                                    
                                @endphp
                                </td> 
                                <td>
                                    
                                   
                                    <a href="{{action('UserController@show',$user->id)}}" class="btn btn-warning btn-sm  m-1">Edit</a>
                                    <form action="{{action('UserController@destroy', $user->id)}}" method="post">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger btn-sm  m-1" type="submit">Delete</button>
                                    </form>
                                    
                                        
                                </td>                
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        </div>
                    </div>
                    <div class="card-footer">2019
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


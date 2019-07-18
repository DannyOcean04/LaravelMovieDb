@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      @guest
     <div class="card">
       <div class="card-header">Error</div>
       <div class="card-body">
         <p>You do not have access to this page</p>
       </div>
     </div>
     @else
      <div class="card">
        <div class="card-header">Display all movies</div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Director</th>
                <th>Title</th>
                <th>Poster</th>
                <th colspan="3">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($movies as $movie)
              <tr>
                <td>{{$movie['director']}}</td>
                <td>{{$movie['title']}}</td>

                <td><img style="width:75%;height:15%"
                  src="{{ asset('storage/images/'.$movie['image'])}}"></td>
                <td><a href="{{action('MovieController@show', $movie['id'])}}" class="btn btn-primary">Details</a></td>

                 @if (Auth::user()->role == 1)
                  <td><a href="{{action('MovieController@edit', $movie['id'])}}" class="btn btn-warning">Edit</a></td>
                    <td>
                      <form action="{{action('MovieController@destroy', $movie['id'])}}"
                      method="post"> @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button class="btn btn-danger" type="submit"> Delete</button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endguest
      </div>
    </div>
  </div>
  @endsection

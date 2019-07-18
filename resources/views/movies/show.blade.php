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
      <!-- display the errors -->
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul> @foreach ($errors->all() as $error)
          <li>{{ $error }}</li> @endforeach
        </ul>
      </div><br /> @endif
      <!-- display the success status -->
      @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br /> @endif

      <div class="card">
        <div class="card-header">Display Movie</div>
        <div class="card-body">
          <table class="table table-striped" border="1" >
            <tr> <td> <b>Director </th> <td> {{$movie['director']}}</td></tr>
              <tr> <th>Title</th> <td>{{$movie->title}}</td></tr>
              <tr> <td>Runtime</th> <td>{{$movie->runtime}}</td></tr>
              <tr> <td>Genre</th> <td>{{$movie->genre}}</td></tr>
              <tr> <td>Year</th> <td>{{$movie->year}}</td></tr>

              <tr> <td colspan='2' ><img style="width:100%;height:100%"
                src="{{ asset('storage/images/'.$movie->image)}}"></td></tr>
              </table>
              <table><tr>
                <td><a href="{{route('movies.index')}}" class="btn btn-primary" role="button">Back to the list</a></td>
                @if (Auth::user()->role == 1)
                  <td><a href="{{action('MovieController@edit', $movie['id'])}}" class="btn btn-warning">Edit</a></td>
                    <td><form action="{{action('MovieController@destroy', $movie['id'])}}"
                      method="post"> @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button class="btn btn-danger" type="submit">Delete</button>
                    </form></td>
                    @endif

                   <td><a href="{{action('ReviewController@create')}}" class="btn btn-success" role="button">Create Review</a></td>
                  </tr></table>
                </div>
              </div>
              @endguest
            </div>
          </div>
        </div>
        @endsection

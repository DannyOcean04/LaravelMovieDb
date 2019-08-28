@extends('layouts.app')
@section('content')
<?php use App\Http\Controllers\MovieController;?>
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

      <div class="card text-center text-black border-dark bg-light mb-3">


        <div class="card-body">
          <h5 class="card-title">{{$movie['title']}}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{$movie['director']}}</h6>
          <h6 class="card-subtitle mb-2 text-muted">{{$movie['runtime']}} mins</h6>
          <h6 class="card-subtitle mb-2 text-muted">{{$movie['genre']}}</h6>
          <h6 class="card-subtitle mb-2 text-muted">{{$movie['year']}}</h6>
          <h6 class="card-subtitle mb-2 text-muted">{{ MovieController::averageRating($movie['id'])}}/5 </h6>

          <div class="btn-group" role="group" aria-label="Basic example">

            <a href="{{route('movies.index')}}" class="btn btn-primary" role="button">Back to the list</a>
            @if (Auth::user()->role == 1)
            <a href="{{action('MovieController@edit', $movie['id'])}}" class="btn btn-warning">Edit</a>
            <form action="{{action('MovieController@destroy', $movie['id'])}}"
            method="post"> @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
          @endif

          <a href="{{action('ReviewController@show', $movie['id'])}}" class="btn btn-success">Create Review</a>

        </div>

                </div>
              </div>

              <div class="card">
                <div class="card-header">Movie Review</div>
                <div class="card-body">
                  <table class="table table-striped" border="1" >

                    <thead>
                      <tr>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comments</th>
                      </tr>
                    </thead>


                    <tbody>
                      @foreach($reviews as $review)
                      @if($review["movieid"]==$movie["id"])
                      @foreach($users as $user)
                      @if($review["userid"]==$user["id"])

                      <tr>
                        <!--  edit below -->

                        <td>{{$user['name']}}</td>
                        <td>{{$review['rating']}}</td>
                        <td>{{$review['comments']}}</td>

                        </tr>
                        @endif
                        @endforeach
                        @endif
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

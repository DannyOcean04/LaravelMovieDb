@extends('layouts.app')
<!-- This blade.php page displays all requests to staff, and displays requests that the specific user has made to users-->
@section('content')

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
<!-- display the warning status -->
@if (\Session::has('warning'))
<div class="alert alert-warning">
  <p>{{ \Session::get('warning') }}</p>
</div><br /> @endif


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      <!-- below is code for displaying review  -->

      @guest
      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else

      @if(Auth::user()->role == 1)
      <div class="card">
        <div class="card-header">Display All Reviews</div>
        <div class="card-body">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th>Review ID</th>
                <th>User ID</th>
                <th>Movie ID</th>
                <th>Movie Title</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Delete</th>
                <th>Edit</th>

              </tr>
            </thead>
            <tbody>
              @foreach($reviews as $review)
              @foreach($movies as $movie)
              @if($review->movieid==$movie['id'])
              @foreach($users as $user)
              @if($review->userid==$user['id'])
              <tr>
                <!--  edit below -->
                <td>{{$review->id}}</td>
                <td>{{$review->userid}}</td>
                <td>{{$review->movieid}}</td>
                <td>{{$movie['title']}}</td>
                <td>{{$review->rating}}</td>
                <td>{{$review->comments}}</td>


                <td> <form action="{{action('MovieController@destroy', $movie['id'])}}"
                  method="post"> @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit"> Delete</button>
                </form> </td>


                @if (Auth::user()->id == $review->userid)
                <td>  <a type="button" href="{{action('MovieController@edit', $movie['id'])}}" class="btn btn-warning">Edit</a></td>
                @endif



                </tr>
                @endif
                @endforeach
                @endif
                @endforeach
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
        @else
        <div class="card">
          <div class="card-header">Display My Reviews</div>
          <div class="card-body">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>Movie Title</th>
                  <th>Rating</th>
                  <th>Comment</th>
                  <th>Delete</th>
                  <th>Edit</th>

                </tr>
              </thead>
              <tbody>
                @foreach($reviews as $review)
                @foreach($movies as $movie)
                @if($review->movieid==$movie['id'])
                @foreach($users as $user)
                @if($review->userid==$user['id'])
                @if (Auth::user()->id == $review->userid)
                <tr>
                  <!--  edit below -->
                  <td>{{$movie['title']}}</td>
                  <td>{{$review->rating}}</td>
                  <td>{{$review->comments}}</td>


                  <td> <form action="{{action('MovieController@destroy', $movie['id'])}}"
                    method="post"> @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit"> Delete</button>
                  </form> </td>

                  <td>  <a type="button" href="{{action('MovieController@edit', $movie['id'])}}" class="btn btn-warning">Edit</a></td>

                  </tr>
                    @endif
                  @endif
                  @endforeach
                  @endif
                  @endforeach
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>

        @endif

        <div>
          <div class="col-md-2">
          {{$reviews->links() }}
        </div>
      @endguest
    </div>
  </div>
</div>
@endsection

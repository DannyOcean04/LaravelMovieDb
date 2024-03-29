<!-- inherite master template app.blade.php -->
@extends('layouts.app')
<!-- define the content section -->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 ">
      @guest
     <div class="card">
       <div class="card-header">Error</div>
       <div class="card-body">
         <p>You do not have access to this page</p>
       </div>
     </div>
     @else
      <div class="card">
        <div class="card-header">Create an new review</div>
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
        <!-- define the form -->
        <div class="card-body">
          <form class="form-horizontal" method="POST"
          action="{{url('reviews') }}" enctype="multipart/form-data">
          @csrf


          <div class="col-md-6 col-md-offset-4">
            <label>Rating</label>
            <select name="rating" >
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>

          <div class="col-md-6 col-md-offset-2">
            <label >Comments</label>
            <textarea rows="3" cols="120" name="comments">Comments about the movie</textarea>
          </div>


          <div class="col-md-6 col-md-offset-4">
            <?php $movieID = $movie['id'];?>
            <input type="hidden" name="mID" value={{$movieID}} />

            <input type="submit" class="btn btn-success" />

          </div>


          </form>
        </div>
      </div>
      @endguest
    </div>
  </div>
</div>
@endsection

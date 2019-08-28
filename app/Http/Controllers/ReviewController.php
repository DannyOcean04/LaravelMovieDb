<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Movie;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{


  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $movies = Movie::all()->toArray();
    $reviews = DB::table('reviews')->paginate(5);
    $users = User::all()->toArray();

    return view('reviews.index', compact('movies','reviews','users'));
  }

  public function create()
  {
    return view('reviews.create');
  }

  public function show($id)
  {
    $movie = Movie::find($id);
    return view('reviews.create',compact('movie'));

  }


  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // form validation
    $review = $this->validate(request(), [
      'rating' => 'required',
      'comments' => 'required',
    ]);


    $movieID = $request->input('mID');

    $reviews=Review::all()->toArray();
    foreach($reviews as $rev)
    {
      if($rev["userid"]==Auth::user()->id)
      {
        if($rev["movieid"]==$movieID)
        {
          return back()->withErrors("Review has already been made.");
        }
      }
    }
    // create a review object and set its values from the input
    $review = new review;
    $review->userid = Auth::user()->id;
    $review->rating = $request->input('rating');
    $review->comments = $request->input('comments');
    $review->movieid = $movieID;
    $review->created_at = now();

    // save the review object
    $review->save();
    // generate a redirect HTTP response with a success message
    return back()->with('success', 'review has been added');

  }

}

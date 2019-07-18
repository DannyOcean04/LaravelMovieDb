<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Movie;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
  public function create()
  {
    return view('reviews.create');
  }


  public function submitReview($movieID)
       {
         //below creates an array of the table data and... tl;dr if both userid and movie id are the same as a pair, then it will error. if userid is same but movie id is diff, then is ok.
         //create variable name, based on the model, and essentially creates an array of all the data in the table
         $reviews=Review::all()->toArray();
         foreach($reviews as $review)
         {
             if($review["userid"]==Auth::user()->id)
             {
               if($review["movieID"]==$movieID)
               {
                 return back()->withErrors("Review has already been made.");
               }
             }
         }


         // create a Animal object and set its values from the input
         $review = new review;

         $review->userid = Auth::user()->id;
         $review->movieID = $movieID;
         $review->dateSubmitted = now();
         $review->created_at = now();

         $review->save();
         // generate a redirect HTTP response with a success message
         return back()->with('success', 'Request has been made');
       }
}

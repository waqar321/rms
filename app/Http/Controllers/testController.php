<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Quiz;

class testController extends Controller
{
    public function index()
    {
         // Make a GET request to your local API endpoint
         $client = new Client();

        //  dd('done testing');
         try {
             // Make a GET request to the API endpoint
             $response = $client->get('http://127.0.0.1:8000/api/testingApi');
     
             // Check the response status code
             if ($response->getStatusCode() === 200) 
             {
                 // API is working
                 echo "API is working.";
             }
             else 
             {
                 // API is not working
                 echo "API is not working. Status code: " . $response->getStatusCode();
             }
         } 
         catch (RequestException $e) 
         {
             // Exception occurred, API is not accessible
             echo "Error accessing API: " . $e->getMessage();
         }

        return view('testdemo');
    }
    public function testFront()
    {
        return view('Frontend.test');
    }
    public function playvideo()
    {
        return view('playvideo');

    }
    // public function showQuizForm()
    // {
    //     $quizzes = Quiz::inRandomOrder()->take(5)->get(); // Get 5 random quizzes
    //     return view('quiz-form', compact('quizzes'));
    // }

    // public function submitQuiz(Request $request)
    // {
    //     // Validate quiz submissions
    //     // Store submissions in database if needed
    //     return response()->json(['message' => 'Quizzes submitted successfully']);
    // }
}

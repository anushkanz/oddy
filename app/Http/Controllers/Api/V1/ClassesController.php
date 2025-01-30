<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Instructor;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ClassesController extends Controller{
    public function index()
    {
        $classes = Classes::all();
        return response()->json([
            'status' => true,
            'message' => 'Users retrieved successfully',
            'data' => $classes
        ], 200);
    }
}
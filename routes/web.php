<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom_login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
    Route::get('/forget_password', [CustomAuthController::class, 'forgetPassword'])->name('login.forget_password');
    // Route::post('/forget_password', [CustomAuthController::class, 'forgetPasswordPost'])->name('login.forget_password.update');
    // Route::get('/reset_password/{token}/{email}', [CustomAuthController::class, 'resetPassword'])->name('login.reset_password');
    // Route::post('/reset_password', [CustomAuthController::class, 'resetPasswordPost'])->name('login.reset_password.post');
    // Route::get('/verify/{token}', [CustomAuthController::class, 'verifyAccount'])->name('user.verify'); 

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

    /**
     * Administrator
     **/

    Route::get('administrator/dashboard', [AdministratorController::class, 'dashboard'])->name('administrator.dashboard');

    Route::get('administrator/courses', [AdministratorController::class, 'courses'])->name('administrator.courses'); //Return all Courses
    Route::get('administrator/course/{id}', [AdministratorController::class, 'course'])->name('administrator.course'); //Return specific Course
    Route::post('administrator/course', [AdministratorController::class, 'updateCourse'])->name('administrator.course.update');

    Route::get('administrator/members', [AdministratorController::class, 'members'])->name('administrator.members');
    Route::get('administrator/member/{id}', [AdministratorController::class, 'member'])->name('administrator.member');
    Route::post('administrator/member', [AdministratorController::class, 'updateMember'])->name('administrator.member.update');

    Route::get('administrator/categories', [AdministratorController::class, 'categories'])->name('administrator.categories');
    Route::get('administrator/category/{id}', [AdministratorController::class, 'category'])->name('administrator.category');
    Route::post('administrator/category', [AdministratorController::class, 'updateCategory'])->name('administrator.category.update');

    Route::get('administrator/bookings', [AdministratorController::class, 'bookings'])->name('administrator.bookings');
    Route::get('administrator/booking/{id}', [AdministratorController::class, 'booking'])->name('administrator.booking');
    Route::post('administrator/booking', [AdministratorController::class, 'updateBooking'])->name('administrator.booking.update');

    Route::get('administrator/reviews', [AdministratorController::class, 'reviews'])->name('administrator.reviews');
    Route::get('administrator/review/{id}', [AdministratorController::class, 'review'])->name('administrator.review');
    Route::post('administrator/review', [AdministratorController::class, 'updateReviews'])->name('administrator.review.update');

    Route::get('administrator/payments', [AdministratorController::class, 'payments'])->name('administrator.payments');
    Route::get('administrator/payment/{id}', [AdministratorController::class, 'payment'])->name('administrator.payment');
    Route::post('administrator/payment', [AdministratorController::class, 'updatePayments'])->name('administrator.payment.update');

    Route::get('administrator/account/', [AdministratorController::class, 'account'])->name('administrator.account'); 
    Route::post('administrator/account', [AdministratorController::class, 'updateAccount'])->name('administrator.account.update');

    /**
     * Instructor
     **/

    Route::get('instructor/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');

    Route::get('instructor/courses', [InstructorController::class, 'courses'])->name('instructor.courses'); //Return all Courses by user
    Route::get('instructor/course/{id}', [InstructorController::class, 'course'])->name('instructor.course'); //Return specific Course
    Route::post('instructor/course', [InstructorController::class, 'updateCourse'])->name('instructor.course.update');
    Route::get('instructor/course/image/{id}', [InstructorController::class, 'courseImage'])->name('instructor.course.image'); 
    Route::post('instructor/course/image/', [InstructorController::class, 'courseImageUpdate'])->name('instructor.course.image.update'); 
    Route::post('instructor/course/ajaximage', [InstructorController::class, 'ajaxImage'])->name('instructor.course.image.ajax');

    Route::get('instructor/locations', [InstructorController::class, 'locations'])->name('instructor.locations'); 
    Route::get('instructor/location/{id}', [InstructorController::class, 'location'])->name('instructor.location');
    Route::post('instructor/location/ajaxlocation', [InstructorController::class, 'ajaxLocations'])->name('instructor.location.ajax');
    Route::post('instructor/location/ajaxclassdates', [InstructorController::class, 'ajaxClassdateDelete'])->name('instructor.classdatedeleted.ajax');
    Route::post('instructor/location', [InstructorController::class, 'updateLocations'])->name('instructor.location.update');



    Route::get('instructor/bookings', [InstructorController::class, 'bookings'])->name('instructor.bookings');
    Route::get('instructor/booking/{id}', [InstructorController::class, 'booking'])->name('instructor.booking');
    
    Route::get('instructor/reviews', [InstructorController::class, 'reviews'])->name('instructor.reviews');
    Route::get('instructor/review/{id}', [InstructorController::class, 'review'])->name('instructor.review');
    Route::post('instructor/review', [InstructorController::class, 'updateReviews'])->name('instructor.review.update');
    
    Route::get('instructor/account/', [InstructorController::class, 'account'])->name('instructor.account'); 
    Route::post('instructor/account', [InstructorController::class, 'updateAccount'])->name('instructor.account.update');

    /**
     * Studuent
     **/

    Route::get('student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    Route::get('student/bookings', [StudentController::class, 'bookings'])->name('student.bookings');
    Route::get('student/booking/{id}', [StudentController::class, 'booking'])->name('student.booking');
    Route::post('student/booking', [StudentController::class, 'updateBooking'])->name('student.booking.update');

    Route::get('student/reviews', [StudentController::class, 'reviews'])->name('student.reviews');
    Route::get('student/review/{id}', [StudentController::class, 'review'])->name('student.review');
    Route::post('student/review', [StudentController::class, 'updateReviews'])->name('student.review.update');

    Route::get('student/account/', [StudentController::class, 'account'])->name('student.account'); 
    Route::post('student/account', [StudentController::class, 'updateAccount'])->name('student.account.update');

});
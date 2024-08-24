<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Exports\AttendanceExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

// Login & logout function
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//Staff Booking
Route::get('staff/booking', 'StaffBookingController@showForm')->name('staff.booking.form');
Route::post('staff/booking/check', 'StaffBookingController@checkStaffId')->name('staff.booking.check');
Route::post('staff/booking/store', 'StaffBookingController@store')->name('staff.booking.store');
Route::get('staff/booking/{id}/print', 'StaffBookingController@printTicket')->name('staff.booking.print');
Route::get('staff/booking/view/{id}', 'StaffBookingController@show')->name('staff.booking.view');

Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    // User Profile
    Route::get('profile/{id}', 'UserProfileController@show')->name('profile.show');
    Route::get('profile/{id}/edit', 'UserProfileController@edit')->name('profile.edit');
    Route::put('profile/{id}', 'UserProfileController@update')->name('profile.update');
    Route::get('profile/{id}/change-password', 'UserProfileController@changePasswordForm')->name('profile.change-password');
    Route::post('profile/{id}/change-password', 'UserProfileController@changePassword')->name('profile.update-password');

    // Superadmin - Activity Log
    Route::get('activity-log', 'ActivityLogController@index')->name('activity-log');
    Route::get('/debug-logs', 'ActivityLogController@showDebugLogs')->name('logs.debug');

    // User Management
    Route::get('user', 'UserController@index')->name('user');
    Route::get('user/create', 'UserController@create')->name('user.create');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::get('user/{id}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/{id}', 'UserController@update')->name('user.update');
    Route::get('user/view/{id}', 'UserController@show')->name('user.show');
    Route::get('/user/search', 'UserController@search')->name('user.search');
    Route::delete('user/{id}', 'UserController@destroy')->name('user.destroy');
    Route::get('/user/trash', 'UserController@trashList')->name('user.trash');
    Route::get('/user/{id}/restore', 'UserController@restore')->name('user.restore');
    Route::delete('/user/{id}/force-delete', 'UserController@forceDelete')->name('user.forceDelete');

    // User Role Management
    Route::get('user-role', 'UserRoleController@index')->name('user-role');
    Route::get('user-role/create', 'UserRoleController@create')->name('user-role.create');
    Route::post('user-role/store', 'UserRoleController@store')->name('user-role.store');
    Route::get('user-role/{id}/edit', 'UserRoleController@edit')->name('user-role.edit');
    Route::post('user-role/{id}', 'UserRoleController@update')->name('user-role.update');
    Route::get('user-role/view/{id}', 'UserRoleController@show')->name('user-role.show');
    Route::get('/user-role/search', 'UserRoleController@search')->name('user-role.search');
    Route::delete('user-role/{id}', 'UserRoleController@destroy')->name('user-role.destroy');
    Route::get('/user-role/trash', 'UserRoleController@trashList')->name('user-role.trash');
    Route::get('/user-role/{id}/restore', 'UserRoleController@restore')->name('user-role.restore');
    Route::delete('/user-role/{id}/force-delete', 'UserRoleController@forceDelete')->name('user-role.forceDelete');


    // Staff Management
    Route::get('staff', 'StaffController@index')->name('staff');
    Route::get('staff/view/{id}', 'StaffController@show')->name('staff.show');
    Route::get('/staff/search', 'StaffController@search')->name('staff.search');
    Route::post('/import-staff', 'StaffController@import')->name('staff.import');
    Route::get('staff/create', 'StaffController@create')->name('staff.create');
    Route::post('staff/store', 'StaffController@store')->name('staff.store');
    Route::get('staff/{id}/edit', 'StaffController@edit')->name('staff.edit');
    Route::post('staff/{id}', 'StaffController@update')->name('staff.update');
    Route::delete('staff/{id}', 'StaffController@destroy')->name('staff.destroy');
    Route::get('/staff/trash', 'StaffController@trashList')->name('staff.trash');
    Route::get('/staff/{id}/restore', 'StaffController@restore')->name('staff.restore');
    Route::delete('/staff/{id}/force-delete', 'StaffController@forceDelete')->name('staff.forceDelete');

    // Booking Management
    Route::get('booking', 'BookingController@index')->name('booking');
    Route::get('booking/create', 'BookingController@create')->name('booking.create');
    Route::post('booking/store', 'BookingController@store')->name('booking.store');
    Route::get('booking/{id}/edit', 'BookingController@edit')->name('booking.edit');
    Route::post('booking/{id}', 'BookingController@update')->name('booking.update');
    Route::get('booking/view/{id}', 'BookingController@show')->name('booking.show');
    Route::get('/booking/search', 'BookingController@search')->name('booking.search');
    Route::delete('booking/{id}', 'BookingController@destroy')->name('booking.destroy');
    Route::get('/booking/trash', 'BookingController@trashList')->name('booking.trash');
    Route::get('/booking/{id}/restore', 'BookingController@restore')->name('booking.restore');
    Route::delete('/booking/{id}/force-delete', 'BookingController@forceDelete')->name('booking.forceDelete');

    // Table Management
    Route::get('table', 'TableController@index')->name('table');
    Route::get('table/create', 'TableController@create')->name('table.create');
    Route::post('table/store', 'TableController@store')->name('table.store');
    Route::get('table/{id}/edit', 'TableController@edit')->name('table.edit');
    Route::post('table/{id}/update', 'TableController@update')->name('table.update');
    Route::get('table/view/{id}', 'TableController@show')->name('table.show');
    Route::get('/table/search', 'TableController@search')->name('table.search');
    Route::delete('table/{id}', 'TableController@destroy')->name('table.destroy');
    Route::get('/table/trash', 'TableController@trashList')->name('table.trash');
    Route::get('/table/{id}/restore', 'TableController@restore')->name('table.restore');
    Route::delete('/table/{id}/force-delete', 'TableController@forceDelete')->name('table.forceDelete');

    // Campus
    Route::get('campus', 'CampusController@index')->name('campus');
    Route::get('campus/view/{id}', 'CampusController@show')->name('campus.show');
    Route::get('/campus/search', 'CampusController@search')->name('campus.search');

    // Position
    Route::get('position', 'PositionController@index')->name('position');
    Route::get('position/view/{id}', 'PositionController@show')->name('position.show');
    Route::get('/position/search', 'PositionController@search')->name('position.search');

    // Attendance
    Route::get('attendance', 'AttendanceController@index')->name('attendance');
    Route::get('attendance/create', 'AttendanceController@create')->name('attendance.create');
    Route::post('attendance/store', 'AttendanceController@store')->name('attendance.store');
    Route::get('attendance/{id}/edit', 'AttendanceController@edit')->name('attendance.edit');
    Route::post('attendance/{id}/update', 'AttendanceController@update')->name('attendance.update');
    Route::get('attendance/view/{id}', 'AttendanceController@show')->name('attendance.show');
    Route::get('/attendance/search', 'AttendanceController@search')->name('attendance.search');
    Route::delete('attendance/{id}', 'AttendanceController@destroy')->name('attendance.destroy');
    Route::get('/attendance/trash', 'AttendanceController@trashList')->name('attendance.trash');
    Route::get('/attendance/{id}/restore', 'AttendanceController@restore')->name('attendance.restore');
    Route::delete('/attendance/{id}/force-delete', 'AttendanceController@forceDelete')->name('attendance.forceDelete');
    Route::get('/attendance/export', function (Request $request) {
        return Excel::download(new AttendanceExport($request->input('type')), 'Kehadiran-Malam-Gala-2024.xlsx');
    })->name('attendance.export');

});

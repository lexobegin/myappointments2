<?php


Route::get('/', function () {
    return view('welcome');//return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    // Specialty
  Route::get('/specialties', 'SpecialtyController@index');
  Route::get('/specialties/create', 'SpecialtyController@create');
  Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');
  Route::post('/specialties', 'SpecialtyController@store');
  Route::put('/specialties/{specialty}', 'SpecialtyController@update');
  Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');
  
  // Doctors
  Route::resource('doctors', 'DoctorController');
  
  // Patients
  Route::resource('patients', 'PatientController');

  // Charts
  Route::get('/charts/appointments/line', 'ChartController@appointments');
  Route::get('/charts/doctors/column', 'ChartController@doctors');
  Route::get('/charts/doctors/column/data', 'ChartController@doctorsJson');

  // FCM (Firebase Cloud Messaging)
  Route::post('/fcm/send', 'FirebaseController@sendAll');
});

Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
    Route::get('/schedule', 'ScheduleController@edit');
    Route::post('/schedule', 'ScheduleController@store');
});

Route::middleware('auth')->group(function () {

  Route::middleware('phone')->group(function () { 
    Route::get('/appointments/create', 'AppointmentController@create');
    Route::post('/appointments', 'AppointmentController@store');
  });

  Route::get('/profile', 'UserController@edit');//edit muestra formulario de edicion
  Route::post('/profile', 'UserController@update');//update se encarga de procesar el formulario de edit

  Route::get('/appointments', 'AppointmentController@index');
  Route::get('/appointments/{appointment}', 'AppointmentController@show');

  Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
  Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');
  
  Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');

  //Route::get('/appointments/create', 'AppointmentController@create');
  //Route::post('/appointments', 'AppointmentController@store');
  
  //JSON
  Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
  Route::post('/schedule/hours', 'Api\ScheduleController@hours');


});
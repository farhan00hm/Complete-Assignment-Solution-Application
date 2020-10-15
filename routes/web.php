<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'Guest\GuestController@index');
//Route::get('/', 'Auth\AuthController@loginPage');
Route::get('/login', 'Auth\AuthController@loginPage');
Route::get('/register', 'Auth\AuthController@registerPage');
Route::get('/forgot-password', 'Auth\AuthController@ForgotPage');

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/forgot-password', 'Auth\LoginController@recover');
Route::get('/logout', 'Auth\LoginController@logout');

// Socialite routes
Route::get('/redirect/facebook', 'Auth\FBSocialiteController@redirect');
Route::get('/callback/facebook', 'Auth\FBSocialiteController@callback');
Route::get('/redirect/google', 'Auth\GoogleSocialiteController@redirect');
Route::get('/callback/google', 'Auth\GoogleSocialiteController@callback');
Route::get('/socialite/complete', 'Auth\SocialiteController@complete');
Route::get('/socialite/callback-factory', 'Auth\Socialite2Controller@callbackFactory');
Route::get('/auth/dropzone', 'Auth\Socialite2Controller@dropzone');

Route::post('/socialite/complete-profile/student','Auth\SocialiteController@studentCompleteProfile');
Route::post('/socialite/complete-profile/professional', 'Auth\SocialiteController@parentCompleteProfile');
Route::post('/socialite/complete-profile/fl', 'Auth\SocialiteController@seCompleteProfile');
Route::post('/socialite/complete-profile/fl/search', 'Auth\SocialiteController@searchSubjects');

Route::get('/pages/contact-us', 'Guest\PagesController@contactPage');
Route::post('/pages/contact-us', 'Guest\PagesController@contactUs');
Route::get('/pages/how-it-works', 'Guest\PagesController@how');
Route::get('/pages/about', 'Guest\PagesController@about');


Route::get('/test', 'TestController@test');

Route::get('/dashboard', [
	'as' => 'dashboard',
	'uses' => 'Dashboard\DashboardController@index'
])->middleware(['role:Admin|Subadmin|FL|Professional|Student|SubCS|SubD|SubP|SubAuth|SubSys']);


/*===========================================================================
* Student routes
=============================================================================
*/
// Get onboarding page
Route::get('/onboarding/student', [
	'as' => 'onboarding.student',
	'uses' => 'Onboarding\StudentController@index'
])->middleware(['role:Student']);

// Onboard a student
Route::post('/onboard/student', [
	'as' => 'onboarding.student.create',
	'uses' => 'Onboarding\StudentController@onboard'
])->middleware(['role:Student']);


/*===========================================================================
* Professional routes
=============================================================================
*/
// Get onboarding page
Route::get('/onboarding/professional', [
	'as' => 'onboarding.professional',
	'uses' => 'Onboarding\ProfessionalController@index'
])->middleware(['role:Professional']);

// Onboard a professional
Route::post('/onboard/professional', [
	'as' => 'onboarding.professional.create',
	'uses' => 'Onboarding\ProfessionalController@onboard'
])->middleware(['role:Professional']);


/*===========================================================================
* Freelancer (FL) routes
=============================================================================
*/
// Get application page
Route::get('/freelancer/apply', [
	'as' => 'freelancer.apply',
	'uses' => 'FL\ApplicationController@index'
]);

// FL submit an application
Route::post('/freelancer/applications/submit', [
	'as' => 'freelancer.application.submit',
	'uses' => 'FL\ApplicationController@submit'
]);



/*===========================================================================
* Category routes
=============================================================================
*/
// Get all categories
Route::get('/categories', [
	'as' => 'categories',
	'uses' => 'Category\CategoryController@index'
])->middleware(['role:Admin|SubSys']);

// Add a new category view
Route::get('/categories/new', [
	'as' => 'categories.new',
	'uses' => 'Category\CategoryController@new'
])->middleware(['role:Admin|SubSys']);

// Create a category
Route::post('/categories/create', [
	'as' => 'categories.create',
	'uses' => 'Category\CategoryController@create'
])->middleware(['role:Admin|SubSys']);

// Get subcategories of a category
Route::post('/categories/get-subs', [
	'as' => 'categories.get-subs',
	'uses' => 'Category\CategoryController@getSubs'
])->middleware(['role:Admin|SubSys|Student|Professional|FL']);

// Edit category view
Route::get('/categories/edit/{uuid}', [
	'as' => 'categories.edit',
	'uses' => 'Category\CategoryController@edit'
])->middleware(['role:Admin|SubSys']);

// Update a category
Route::post('/categories/update', [
	'as' => 'categories.update',
	'uses' => 'Category\CategoryController@update'
])->middleware(['role:Admin|SubSys']);

// Delete a category
Route::post('/categories/delete', [
	'as' => 'categories.delete',
	'uses' => 'Category\CategoryController@delete'
])->middleware(['role:Admin|SubSys']);


// Get all sub categories
Route::get('/categories/sub-categories', [
	'as' => 'categories.sub-categories',
	'uses' => 'Category\SubCategoryController@index'
])->middleware(['role:Admin|SubSys']);

// Add a new sub category view
Route::get('/categories/sub-categories/new', [
	'as' => 'categories.sub-categories.new',
	'uses' => 'Category\SubCategoryController@new'
])->middleware(['role:Admin|SubSys']);

// Create a sub category
Route::post('/categories/sub-categories/create', [
	'as' => 'categories.sub-categories.create',
	'uses' => 'Category\SubCategoryController@create'
])->middleware(['role:Admin|SubSys']);

// Edit sub category view
Route::get('/categories/sub-categories/edit/{uuid}', [
	'as' => 'categories.sub-categories.edit',
	'uses' => 'Category\SubCategoryController@edit'
])->middleware(['role:Admin|SubSys']);

// Update a sub category
Route::post('/categories/sub-categories/update', [
	'as' => 'categories.sub-categories.update',
	'uses' => 'Category\SubCategoryController@update'
])->middleware(['role:Admin|SubSys']);

// Delete a sub category
Route::post('/categories/sub-categories/delete', [
	'as' => 'categories.sub-categories.delete',
	'uses' => 'Category\SubCategoryController@delete'
])->middleware(['role:Admin|SubSys']);







/*===========================================================================
* Admin and Subadmin routes
=============================================================================
*/
// Get all
Route::get('/users/subadmins', [
	'as' => 'users.subadmins',
	'uses' => 'User\SubadminController@index'
])->middleware(['role:Admin']);

// Get create subadmin page
Route::get('/users/subadmins/new', [
	'as' => 'users.subadmins.new',
	'uses' => 'User\SubadminController@new'
])->middleware(['role:Admin']);

// Create subadmin page
Route::post('/users/subadmins/create', [
	'as' => 'users.subadmins.create',
	'uses' => 'User\SubadminController@create'
])->middleware(['role:Admin']);

// Get edit subadmin page
Route::get('/users/subadmins/edit/{uuid}', [
	'as' => 'users.subadmins.edit',
	'uses' => 'User\SubadminController@edit'
])->middleware(['role:Admin']);

// Update subadmin details
Route::post('/users/subadmins/update', [
	'as' => 'users.subadmins.update',
	'uses' => 'User\SubadminController@update'
])->middleware(['role:Admin']);

// Delete a subadmin
Route::post('/users/subadmins/delete', [
	'as' => 'users.subadmins.delete',
	'uses' => 'User\SubadminController@delete'
])->middleware(['role:Admin']);

// Get pending freelancers
Route::get('/users/freelancers/pending-approval', [
	'as' => 'users.freelancers.pending-approval',
	'uses' => 'User\ExpertController@pendingApproval'
])->middleware(['role:Admin|SubAuth']);

// Approve freelancers application
Route::post('/users/freelancers/pending/approve', [
	'as' => 'users.freelancers.pending.approve',
	'uses' => 'User\ExpertController@approve'
])->middleware(['role:Admin|SubAuth']);

// Request for more information
Route::post('/users/freelancers/pending/request-info', [
	'as' => 'users.freelancers.pending.request-info',
	'uses' => 'User\ExpertController@requestInfo'
])->middleware(['role:Admin|SubAuth']);

// Decline freelancers application
Route::post('/users/freelancers/pending/decline', [
	'as' => 'users.freelancers.pending.decline',
	'uses' => 'User\ExpertController@decline'
])->middleware(['role:Admin|SubAuth']);

// Get a single pending freelancers
Route::get('/users/freelancers/pending-approval/{uuid}', [
	'as' => 'users.freelancers.pending-approval.single',
	'uses' => 'User\ExpertController@single'
])->middleware(['role:Admin|SubAuth']);

// Get approved freelancers
Route::get('/users/freelancers/approved', [
	'as' => 'users.freelancers.approved',
	'uses' => 'User\ExpertController@approved'
])->middleware(['role:Admin|SubAuth']);

// Get a single freelancers profile
Route::get('/users/freelancers/profile/{uuid}', [
	'as' => 'users.freelancers.profile',
	'uses' => 'User\ExpertController@profile'
])->middleware(['role:Admin|Subadmin|Student|Professional|SubD|SubCS|SubP|SubAuth|SubSys']);



// Get all students/Non students
Route::get('/users/students', [
	'as' => 'users.students.index',
	'uses' => 'User\StudentController@index'
])->middleware(['role:Admin|Subadmin|SubSys|SubCS']);

// Get all a students/Non students profile
Route::get('/users/students/profile/{uuid}', [
	'as' => 'users.students.profile',
	'uses' => 'User\StudentController@profile'
])->middleware(['role:Admin|Subadmin|SubSys|SubCS|FL']);




/* ================================================================
|| Homework Routes
==================================================================
*/
// Get student post homework page - also used by non students
Route::get('/homeworks/new', [
	'as' => 'homeworks.student.new',
	'uses' => 'Homework\StudentHomeworkController@index'
])->middleware(['role:Student|Professional','check_user_verification']);

// Create a homework
Route::post('/homeworks/create', [
	'as' => 'homeworks.student.create',
	'uses' => 'Homework\StudentHomeworkController@create'
])->middleware(['role:Student|Professional','check_user_verification']);

// Get student edit homework page - also used by non students
Route::get('/homeworks/edit/{uuid}', [
	'as' => 'homeworks.student.edit',
	'uses' => 'Homework\StudentHomeworkController@edit'
])->middleware(['role:Student|Professional','check_user_verification']);

// Delete homework file
Route::post('/homeworks/files/delete', [
	'as' => 'homeworks.student.files.delete',
	'uses' => 'Homework\StudentHomeworkController@deleteFile'
])->middleware(['role:Student|Professional']);

// Update a homework
Route::post('/homeworks/update', [
	'as' => 'homeworks.student.update',
	'uses' => 'Homework\StudentHomeworkController@update'
])->middleware(['role:Student|Professional']);

// Delete a homework
Route::post('/homeworks/delete', [
	'as' => 'homeworks.student.delete',
	'uses' => 'Homework\StudentHomeworkController@delete'
])->middleware(['role:Student|Professional']);

// Get open homeworks
Route::get('/homeworks/open', [
	'as' => 'homeworks.student.open',
	'uses' => 'Homework\StudentHomeworkController@open'
])->middleware(['role:Student|Professional']);

// Get ongoing homeworks
Route::get('/homeworks/ongoing', [
	'as' => 'homeworks.student.ongoing',
	'uses' => 'Homework\StudentHomeworkController@ongoing'
])->middleware(['role:Student|Professional']);

// Get completed homeworks (students)
Route::get('/homeworks/completed', [
	'as' => 'homeworks.student.completed',
	'uses' => 'Homework\StudentHomeworkActionsController@completed'
])->middleware(['role:Student|Professional']);

// Student approve homework solution
Route::post('/homeworks/solution/approve', [
	'as' => 'homeworks.student.solution.approve',
	'uses' => 'Homework\StudentHomeworkActionsController@approveSolution'
])->middleware(['role:Student|Professional']);

// Student request homework solution revision
Route::post('/homeworks/solution/revision', [
	'as' => 'homeworks.student.solution.revision',
	'uses' => 'Homework\StudentHomeworkActionsController@requestRevision'
])->middleware(['role:Student|Professional']);

// Get a single homework view
Route::get('/homeworks/single/{uuid}', [
	'as' => 'homeworks.single',
	'uses' => 'Homework\HomeworkController@single'

])->middleware(['role:Student|Professional|FL|Subadmin|Admin|SubD|SubCS|SubP|SubAuth|SubSys']);


// Get a single homework view SE
Route::get('/homeworks/se-single/{uuid}', [
	'as' => 'homeworks.single',
	'uses' => 'Homework\HomeworkController@se_single'
])->middleware(['role:Professional|SE|Subadmin|Admin|SubD|SubCS|SubP|SubAuth|SubSys']);


// Download homework file
Route::get('/homework/files/download', [
	'as' => 'homework.files.download',
	'uses' => 'Homework\HomeworkController@downloadFile'
])->middleware(['role:Student|Professional|FL|Subadmin|Admin|SubD|SubCS|SubP|SubAuth|SubSys']);

// Get all open homeworks - freelancers
Route::get('/freelancer/homeworks/open', [
	'as' => 'homeworks.fl.open',
	'uses' => 'Homework\SEHomeworkController@open'
])->middleware(['role:FL']);

// Get all ongoing homeworks - freelancers
Route::get('/freelancer/homeworks/ongoing', [
	'as' => 'homeworks.fl.ongoing',
	'uses' => 'Homework\SEHomeworkController@ongoing'
])->middleware(['role:FL']);


// Get submit homework page - freelancers

// Delete a homework - solution experts
// Route::post('/so/homeworks/delete', [
// 	'as' => 'homeworks.se.delete',
// 	'uses' => 'Homework\SEHomeworkController@delete'
// ])->middleware(['role:SE']);

// Get submit homework page - solution experts

Route::get('/homeworks/submit/{uuid}', [
	'as' => 'homeworks.fl.submit',
	'uses' => 'Homework\SEHomeworkController@submitPage'
])->middleware(['role:FL']);


// Submit homework - freelancers



// Submit homework - solution experts

Route::post('/homeworks/submit', [
	'as' => 'homeworks.submit',
	'uses' => 'Homework\SEHomeworkController@submit'
])->middleware(['role:FL']);

// Get completed homeworks - freelancers
Route::get('/freelancer/homeworks/completed', [
	'as' => 'homeworks.fl.completed',
	'uses' => 'Homework\SEHomeworkController@completed'
])->middleware(['role:FL']);

// Get a homework bids
Route::get('/homeworks/{uuid}/bids', [
	'as' => 'homeworks.bids',
	'uses' => 'Homework\StudentHomeworkController@bids'
])->middleware(['role:Student|Professional']);

// Get archived homeworks
Route::get('/homeworks/archive', [
    'as' => 'homeworks.student.archive',
    'uses' => 'Homework\StudentHomeworkController@archive'
])->middleware(['role:Student|Professional']);

// Get canceled homeworks
Route::get('/homeworks/canceled', [
    'as' => 'homeworks.student.archive',
    'uses' => 'Homework\StudentHomeworkController@canceled'
])->middleware(['role:Student|Professional']);

// Get student edit archive homework page - also used by non students
Route::get('/archive/homeworks/edit/{uuid}', [
    'as' => 'archive.homeworks.student.edit',
    'uses' => 'Homework\StudentHomeworkController@editArchiveHomework'
])->middleware(['role:Student|Professional']);

// Update a archive homework
Route::post('/archive/homeworks/update', [
    'as' => 'archive.homeworks.student.update',
    'uses' => 'Homework\StudentHomeworkController@archiveHomeworkUpdate'
])->middleware(['role:Student|Professional']);

//Repost the homework without update
Route::get('/archive/homeworks/single/update/{uuid}', [
    'as' => 'archive.homeworks.student.edit',
    'uses' => 'Homework\StudentHomeworkController@repostHomework'
])->middleware(['role:Student|Professional']);

/* ================================================================
|| Bids Routes
==================================================================
*/
// Get open bids page - used mostly by FL
Route::get('/bids/open', [
	'as' => 'bids.open',
	'uses' => 'Bid\BidController@open'
])->middleware(['role:FL|Subadmin|Admin']);

// Submit a bid
Route::post('/bids/submit', [
	'as' => 'bids.submit',
	'uses' => 'Bid\BidController@submit'
])->middleware(['role:FL']);

// Withdraw a bid
Route::post('/bids/withdraw', [
	'as' => 'bids.withdraw',
	'uses' => 'Bid\BidController@withdraw'
])->middleware(['role:FL']);

// Get declined bids page - used mostly by FL
Route::get('/bids/declined', [
	'as' => 'bids.declined',
	'uses' => 'Bid\BidController@declined'
])->middleware(['role:FL|Subadmin|Admin']);

// Get counter bids page - used mostly by FL
Route::get('/bids/counter-offers', [
	'as' => 'bids.counter-offers',
	'uses' => 'Bid\BidController@counterOffers'
])->middleware(['role:FL']);

// FL decline a counter offer
Route::post('/bids/counter-offers/decline', [
	'as' => 'bids.counter-offers.decline',
	'uses' => 'Bid\BidController@declineCounter'
])->middleware(['role:FL']);

// FL accept a counter offer
Route::post('/bids/counter-offers/accept', [
	'as' => 'bids.counter-offers.accept',
	'uses' => 'Bid\BidController@acceptCounter'
])->middleware(['role:FL']);

// Hire/Accept bid
Route::post('/bids/hire', [
	'as' => 'bids.hire',
	'uses' => 'Bid\HireController@hire'
])->middleware(['role:Student|Professional']);

// Decline a bid
Route::post('/bids/decline', [
	'as' => 'bids.decline',
	'uses' => 'Bid\HireController@decline'
])->middleware(['role:Student|Professional']);

// Counter offer
Route::post('/bids/counter-offer', [
	'as' => 'bids.counter',
	'uses' => 'Bid\BidController@counter'
])->middleware(['role:Student|Professional']);



/* ================================================================
|| Flag Homework Routes
==================================================================
*/
// Flag a homework
Route::post('/homeworks/flag', [
	'as' => 'homeworks.flag',
	'uses' => 'Homework\FlagHomeworkController@flag'
])->middleware(['role:FL']);

// Admin get flagged homeworks
Route::get('/homeworks/flagged', [
	'as' => 'homeworks.flagged',
	'uses' => 'Homework\FlagHomeworkController@flagged'
])->middleware(['role:Subadmin|Admin|SubD|SubSys']);

// Admin approve flagged homework
Route::post('/homeworks/flagged/approve', [
	'as' => 'homeworks.flagged.approve',
	'uses' => 'Homework\FlagHomeworkController@approve'
])->middleware(['role:Subadmin|Admin|SubD|SubSys']);

// Admin decline flagged homework
Route::post('/homeworks/flagged/decline', [
	'as' => 'homeworks.flagged.decline',
	'uses' => 'Homework\FlagHomeworkController@decline'
])->middleware(['role:Subadmin|Admin|SubD|SubSys']);



/* ================================================================
|| Ratings and Reviews
==================================================================
*/
// Review a homework/solution expert
Route::get('/homeworks/{uuid}/review', [
	'as' => 'reviews.student',
	'uses' => 'Reviews\ReviewSEController@index'
])->middleware(['role:Student|Professional|FL']);

// Student review a solution expert
Route::post('/homeworks/student/review', [
	'as' => 'reviews.student.post',
	'uses' => 'Reviews\ReviewSEController@rate'
])->middleware(['role:Student|Professional|FL']);





/* ================================================================
|| Financial Routes
==================================================================
*/
// Get wallet
Route::get('/user/financials/wallet', [
	'as' => 'user.financials.wallet',
	'uses' => 'Financials\StudentWalletController@index'
])->middleware(['role:Student|Professional']);

// Top up wallet
Route::post('/user/financials/wallet/top-up', [
	'as' => 'user.financials.wallet.top-up',
	'uses' => 'Financials\StudentWalletController@topUp'
])->middleware(['role:Student|Professional','check_user_verification']);

// Top up Paystack callback
Route::post('/user/financials/wallet/top-up/paystack-callback', [
	'as' => 'user.financials.wallet.top-up.paystack-callback',
	'uses' => 'Financials\StudentWalletController@payStackCallback'
])->middleware(['role:Student|Professional']);

// Get all user (Student/Professional) transactions
Route::get('/user/financials/transactions', [
	'as' => 'user.financials.wallet',
	'uses' => 'Financials\StudentTransactionController@index'
])->middleware(['role:Student|Professional']);

// Refund studnet payed amount via Paystack
Route::post('/user/refund', [
	'as' => 'user.refund',
	'uses' => 'Financials\StudentTransactionController@refundPayment'
])->middleware(['role:Student|Professional']);


// Refund studnet while request for refund- Full refund = 0
Route::post('/homeworks/request-refund', [
	'as' => 'homeworks.request-refund',
	'uses' => 'Homework\StudentHomeworkController@refund_request'
])->middleware(['role:Student|Professional']);





// Get all Freelancer transactions
Route::get('/freelancer/financials/transactions', [
	'as' => 'freelancer.financials.wallet',
	'uses' => 'Financials\SETransactionController@index'
])->middleware(['role:FL']);

// Get Freelancer payment receipt
Route::get('/freelancers/payment-receipts/{uuid}', [
	'as' => 'freelancer.payment.receipt',
	'uses' => 'Financials\SETransactionController@viewReceipt'
]);



// Get commissions
Route::get('/financials/commissions', [
	'as' => 'financials.commissions',
	'uses' => 'Financials\CommissionController@index'
])->middleware(['role:Admin|SubP']);


/* ================================================================
|| Messaging Routes
==================================================================
*/
// Get messages
Route::get('/messages', [
	'as' => 'messages',
	'uses' => 'Messaging\MessageController@index'
])->middleware(['role:Student|Professional|FL|Admin|SubCS']);

// Get a room
Route::get('/messages/{uuid}', [
	'as' => 'messages.room',
	'uses' => 'Messaging\MessageController@room'
])->middleware(['role:Student|Professional|FL|Admin|SubCS']);

// Send a message
Route::post('/messages/send', [
	'as' => 'messages.send',
	'uses' => 'Messaging\MessageController@send'
])->middleware(['role:Student|Professional|FL|Admin|SubCS']);

// Refresh a room
Route::post('/messages/refresh', [
	'as' => 'messages.refresh',
	'uses' => 'Messaging\MessageController@refresh'
])->middleware(['role:Student|Professional|FL|Admin|SubCS']);

// Delete messages
Route::post('/messages/rooms/delete', [
	'as' => 'messages.delete',
	'uses' => 'Messaging\MessageController@delete'
])->middleware(['role:Student|Professional|FL']);




/* ================================================================
|| Discount Codes Routes
==================================================================
*/
// Get discount code page
Route::get('/discount-codes', [
	'as' => 'discount-codes',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@index'
])->middleware(['role:Admin|SubSys']);

// Get create discount code page
Route::get('/discount-codes/new', [
	'as' => 'discount-codes.new',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@new'
])->middleware(['role:Admin|SubSys']);

// Get active discount code page
Route::get('/discount-codes/active', [
	'as' => 'discount-codes',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@index'
])->middleware(['role:Admin|SubSys']);

// Get inactive discount code page
Route::get('/discount-codes/inactive', [
	'as' => 'discount-codes',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@inactive'
])->middleware(['role:Admin|SubSys']);

// Create discount code
Route::post('/discount-codes/create', [
	'as' => 'discount-codes.create',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@create'
])->middleware(['role:Admin|SubSys']);

// Admin issue discount code
Route::post('/discount-codes/admin-issue', [
	'as' => 'discount-codes.admin-issue',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@adminIssue'
])->middleware(['role:Admin|SubSys']);

// Delete a discount code
Route::post('/discount-codes/delete', [
	'as' => 'discount-codes.delete',
	'uses' => 'DiscountCodes\AdminDiscountCodesController@delete'
])->middleware(['role:Admin|SubSys']);


// Get user discount code page
Route::get('/user/discount-codes', [
	'as' => 'user.discount-codes',
	'uses' => 'DiscountCodes\UserDiscountCodesController@index'
])->middleware(['role:Student|Professional|FL']);

// Redeem  a discount code
Route::post('/user/discount-codes/redeem', [
	'as' => 'user.discount-codes.redeem',
	'uses' => 'DiscountCodes\UserDiscountCodesController@redeem'
])->middleware(['role:Student|Professional|FL']);





/* ================================================================
|| Settings Routes
==================================================================
*/
// Get settings page
Route::get('/settings', [
	'as' => 'settings',
	'uses' => 'SettingsController@index'
])->middleware(['role:Admin|Subadmin|FL|Professional|Student|SubCS|SubD|SubP|SubAuth|SubSys']);

// Update user profile
Route::post('/settings/profile', [
	'as' => 'settings.profile',
	'uses' => 'SettingsController@updateProfile'
])->middleware(['role:Admin|Subadmin|FL|Professional|Student|SubCS|SubD|SubP|SubAuth|SubSys']);

// Update banking info
Route::post('/settings/banking/update', [
	'as' => 'settings.banking',
	'uses' => 'SettingsController@updateBank'
])->middleware(['role:FL']);

// Update FL academic qualification
Route::post('/settings/academic-qualification/update', [
	'as' => 'settings.academic-qualification.update',
	'uses' => 'SettingsController@updateSEAcademicQualification'
])->middleware(['role:FL']);

// Update FL areas of expertise
Route::post('/settings/areas-of-expertise/update', [
	'as' => 'settings.areas-of-expertise.update',
	'uses' => 'SettingsController@updateSEAreasOfExpertise'
])->middleware(['role:FL']);

// Delete FL areas of expertise
Route::post('/settings/areas-of-expertise/delete', [
	'as' => 'settings.areas-of-expertise.delete',
	'uses' => 'SettingsController@deleteSEAreaOfExpertise'
])->middleware(['role:FL']);

// Reset password
Route::post('/settings/reset-password', [
	'as' => 'settings.reset-password',
	'uses' => 'Auth\LoginController@reset'
])->middleware(['role:Admin|Subadmin|FL|Professional|Student|SubCS|SubD|SubP|SubAuth|SubSys']);


/*=========================================================================================
                         Mark Notifications as read
===========================================================================================*/
Route::get('mark-notification-read/{uuid}','NotificationReadController@markRead');
/*===============================================================================================
                                 Verify User
===============================================================================================*/
Route::get('verify-email/{uuid}','Auth\RegisterController@emailVerification');


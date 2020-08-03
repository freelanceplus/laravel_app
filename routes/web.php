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


use App\Events\WebsocketDemoEvent;

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('/seller/dashboard','Seller\SellerDashboardController@showDashboard');

Route::get('/seller/login','Seller\SellerLoginSignupController@login');
Route::post('/seller/validate','Seller\SellerLoginSignupController@validateSeller');
Route::get('/seller/logout','Seller\SellerLoginSignupController@logout');
//Route::get('/seller/signup','Seller\SellerLoginSignupController@signup');
Route::post('/seller/register','Seller\SellerLoginSignupController@register');
Route::get('/seller/skills', 'Seller\SellerLoginSignupController@addSkills');
Route::post('/seller/registration', 'Seller\SellerSkillsController@registerSkills');
Route::get('/seller/Test/{qNo}','Seller\SellerSkillsController@sellerTest');
Route::post('/seller/submitResult','Seller\SellerSkillsController@submitResults');

Route::get('/seller/signup', [
    'uses' => '\App\Http\Controllers\Seller\SellerLoginSignupController@signup',
    'middleware' => ['guest'],
    'as' => 'sellerSignup',
]);
Route::post('/seller/signup', [
    'uses' => '\App\Http\Controllers\Seller\SellerLoginSignupController@register',
    'middleware' => ['guest'],
]);

Route::get('/seller/sellerLogout', [
    'uses' => '\App\Http\Controllers\Seller\SellerLoginSignupController@sellerLogout',
    'middleware' => ['guest'],
    'as' => 'sellerLogout',
]);

Route::get('/buyer/dashboard','Buyer\BuyerDashboardController@showDashboard');
Route::get('/buyer/login','Buyer\BuyerLoginSignupController@login');
Route::post('/buyer/validate','Buyer\BuyerLoginSignupController@validateBuyer');
Route::get('/buyer/logout','Buyer\BuyerLoginSignupController@logout');
//Route::get('/buyer/signup','Buyer\BuyerLoginSignupController@signup');
//Route::post('/buyer/register','Buyer\BuyerLoginSignupController@register');

Route::get('/','Buyer\BuyerLandingPageController@showLandingPage');
Route::get('/landingPage','Buyer\BuyerLandingPageController@showLandingPage');

Route::get('/buyer/signup', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerLoginSignupController@buyerSignup',
    'middleware' => ['guest'],
    'as' => 'buyerSignup',
]);
Route::post('/buyer/signup', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerLoginSignupController@postBuyerSignup',
    'middleware' => ['guest'],
]);

Route::get('/buyer/dashboard', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerDashboardController@dashboard',
    'middleware' => ['guest'],
    'as' => 'buyerDashboard',
]);

Route::get('/buyer/addProject/step1', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@addProjectStep1',
    'middleware' => ['guest'],
    'as' => 'addProjectStep1',
]);
Route::post('/buyer/addProject/step1', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@postProjectStep1',
    'middleware' => ['guest'],
]);

Route::get('/buyer/addProject/step2', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@addProjectStep2',
    'middleware' => ['guest'],
    'as' => 'addProjectStep2',
]);

Route::post('/buyer/addProject/step2', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@postProjectStep2',
    'middleware' => ['guest'],
]);

Route::get('/buyer/newRequests', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@newRequests',
    'as' => 'buyerNewRequests',
]);

Route::get('/buyer/onGoingProjects', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@inProgress',
    'as' => 'buyerInProgress',
]);

Route::get('/buyer/approvedProjects', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@approvedProjects',
    'as' => 'buyerApprovedProjects',
]);


Route::get('/buyer/deleteProject', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@deleteProject',
    'as' => 'buyerDeleteProject',
]);
Route::get('/buyer/editProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@editProject',
    'as' => 'buyerEditProject',
]);
Route::post('/buyer/editProject', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@postEditProject',
]);

Route::get('/buyer/completedProject', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@completedProjects',
    'as' => 'buyerCompletedProjects',
]);

Route::get('/buyer/reviseProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@reviseProject',
    'as' => 'buyerReviseProject',
]);

Route::post('/buyer/reviseProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@postReviseProject',
    'as' => 'buyerReviseProject',
]);

Route::get('/buyer/getProjectDetails/{order_id}', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@getProjectDetails',
    'as' => 'getProjectDetailsBuyer',
]);

Route::get('/buyer/approveProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@approveProject',
    'as' => 'buyerApproveProject',
]);

Route::get('/buyer/buyerLogout', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerLoginSignupController@buyerLogout',
    'as' => 'buyerLogout',
]);

Route::get('/buyer/buyerAccount', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerAccountController@buyerAccount',
    'as' => 'buyerAccount',
]);

Route::get('/buyer/editProfileBuyer', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerAccountController@editProfileBuyer',
    'as' => 'editProfileBuyer',
]);
Route::post('/buyer/editProfileBuyer', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerAccountController@postEditProfileBuyer',
]);

Route::get('/buyer/changeBuyerPassword', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerAccountController@changeBuyerPassword',
    'as' => 'changeBuyerPassword',
]);
Route::post('/buyer/changeBuyerPassword', [
    'uses' => '\App\Http\Controllers\Buyer\BuyerAccountController@postChangeBuyerPassword',
]);

//Route::get('/buyer/downloadBuyerFiles/{order_id}', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@downloadBuyerFiles',
//    'as' => 'downloadBuyerFilesBuyer',
//]);
//
//Route::get('/buyer/downloadBuyerFiles/{order_id}', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerProjectController@downloadSellerFiles',
//    'as' => 'downloadSellerFilesBuyer',
//]);


////////////////////////////////////////////////admin//////////////////////////////////////////////////

Route::get('/admin/login', [
    'uses' => '\App\Http\Controllers\admin\AdminLoginController@adminLogin',
    'middleware' => ['guest'],
    'as' => 'login',
]);

Route::post('/admin/login', [
    'uses' => '\App\Http\Controllers\admin\AdminLoginController@postAdminLogin',
    'middleware' => ['guest'],
]);

Route::get('/admin/dashboard', [
    'uses' => '\App\Http\Controllers\admin\AdminDashboardController@adminDashboard',
    'middleware' => ['auth:admin'],
    'as' => 'adminDashboard',
]);

Route::get('/admin/newRequests', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@newRequests',
    'middleware' => ['auth:admin'],
    'as' => 'newRequests',
]);

Route::get('/admin/assignProject/{id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@assignProject',
    'middleware' => ['auth:admin'],
    'as' => 'assignProject',
]);

Route::get('/admin/rejectProject/{id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@rejectProject',
    'middleware' => ['auth:admin'],
    'as' => 'rejectProject',
]);

Route::get('/admin/reviseProjectDetails/{order_id}/{seller_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@reviseProjectDetails',
    'middleware' => ['auth:admin'],
    'as' => 'reviseProjectDetails',
]);

Route::post('/admin/assignProjectToSeller', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@assignProjectToSeller',
    'middleware' => ['auth:admin'],
]);

Route::get('/admin/getProjectDetails/{order_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@getProjectDetails',
    'middleware' => ['auth:admin'],
    'as' => 'getProjectDetailsAdmin',
]);

Route::get('/admin/onGoingProjects', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@onGoingProjects',
    'middleware' => ['auth:admin'],
    'as' => 'onGoingProjectsAdmin',
]);

Route::get('/admin/completedProjects', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@completedProjectsAdmin',
    'middleware' => ['auth:admin'],
    'as' => 'completedProjectsAdmin',
]);

Route::get('/admin/approveProject/{order_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@approveProject',
    'middleware' => ['auth:admin'],
    'as' => 'approveProject',
]);


Route::get('/admin/reviseProject/{order_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@reviseProject',
    'middleware' => ['auth:admin'],
    'as' => 'adminReviseProject',
]);

Route::post('/admin/reviseProject/{order_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@postReviseProject',
    'middleware' => ['auth:admin'],
]);

Route::get('/admin/inRevisionProjects', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@inRevisionProjects',
    'middleware' => ['auth:admin'],
    'as' => 'inRevisionProjectsAdmin',
]);

Route::get('/admin/approvedProjects', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@approvedProjectsAdmin',
    'middleware' => ['auth:admin'],
    'as' => 'approvedProjectsAdmin',
]);

Route::get('/admin/acceptedProjects', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@acceptedProjectsAdmin',
    'middleware' => ['auth:admin'],
    'as' => 'acceptedProjectsAdmin',
]);

Route::get('/admin/acceptForRevision/{order_id}', [
    'uses' => '\App\Http\Controllers\admin\AdminProjectsContoller@acceptForRevision',
    'middleware' => ['auth:admin'],
    'as' => 'adminAcceptForRevision',
]);

Route::get('/admin/logout', [
    'uses' => '\App\Http\Controllers\admin\AdminLoginController@getLogout',
    'middleware' => ['auth'],
    'as' => 'adminLogout',
]);

Route::get('/admin/developers', [
    'uses' => '\App\Http\Controllers\admin\AdminDevelopersController@developers',
    'middleware' => ['auth:admin'],
    'as' => 'developers',
]);

Route::get('/admin/developerDetails/{id}', [
    'uses' => '\App\Http\Controllers\admin\AdminDevelopersController@developerDetails',
    'middleware' => ['auth:admin'],
    'as' => 'developerDetails',
]);

Route::get('/admin/getQuestions', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@getQuestions',
    'middleware' => ['auth:admin'],
    'as' => 'getQuestions',
]);

Route::get('/admin/editQuestion/{id}', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@editQuestion',
    'middleware' => ['auth:admin'],
    'as' => 'editQuestion',
]);

Route::post('/admin/editQuestion/{id}', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@postEditQuestion',
    'middleware' => ['auth:admin'],
]);

Route::get('/admin/addQuestion', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@addQuestion',
    'middleware' => ['auth:admin'],
    'as' => 'addQuestion',
]);

Route::post('/admin/addQuestion', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@postAddQuestion',
    'middleware' => ['auth:admin'],
]);

Route::get('/admin/deleteQuestion/{id}', [
    'uses' => '\App\Http\Controllers\admin\QuestionsController@deleteQuestion',
    'middleware' => ['auth:admin'],
    'as' => 'deleteQuestion',
]);

Route::get('/admin/getSkills/', [
    'uses' => '\App\Http\Controllers\admin\SkillsController@getSkills',
    'middleware' => ['auth:admin'],
    'as' => 'getSkills',
]);

Route::get('/admin/addSkill/', [
    'uses' => '\App\Http\Controllers\admin\SkillsController@addSkill',
    'middleware' => ['auth:admin'],
    'as' => 'addSkill',
]);

Route::post('/admin/addSkill/', [
    'uses' => '\App\Http\Controllers\admin\SkillsController@postAddSkill',
    'middleware' => ['auth:admin'],
]);

Route::get('/admin/deleteSkill/{id}', [
    'uses' => '\App\Http\Controllers\admin\SkillsController@deleteSkill',
    'middleware' => ['auth:admin'],
    'as' => 'deleteSkill',
]);



////////////////////////////////////////////////seller//////////////////////////////////////////////////

Route::get('/seller/newRequests', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@newRequests',
    'as' => 'sellerNewRequests',
]);

Route::get('/seller/sellerAcceptProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@sellerAcceptProject',
    'as' => 'sellerAcceptProject',
]);

Route::get('/seller/sellerRejectProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@sellerRejectProject',
    'as' => 'sellerRejectProject',
]);

Route::get('/seller/onGoingProjects', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@onGoingProjects',
    'as' => 'onGoingProjects',
]);

Route::get('/seller/sellerSubmitProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@sellerSubmitProject',
    'as' => 'sellerSubmitProject',
]);

Route::post('/seller/sellerSubmitProject/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@postSellerSubmitProject',
]);

Route::get('/seller/completedProjects', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@completedProjects',
    'as' => 'completedProjects',
]);

Route::get('/seller/approvedProjects', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@approvedProjects',
    'as' => 'approvedProjectsSeller',
]);

Route::get('/seller/getProjectDetails/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@getProjectDetails',
    'as' => 'getProjectDetails',
]);

Route::get('/seller/downloadBuyerFiles/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@downloadBuyerFiles',
    'as' => 'downloadBuyerFiles',
]);

Route::get('/seller/downloadSellerFiles/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@downloadSellerFiles',
    'as' => 'downloadSellerFiles',
]);

Route::get('/seller/inRevisionProjects', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@inRevisionProjects',
    'as' => 'inRevisionProjects',
]);

Route::get('/seller/sellerAcceptForRevision/{order_id}', [
    'uses' => '\App\Http\Controllers\Seller\SellerProjectsController@sellerAcceptForRevision',
    'as' => 'sellerAcceptForRevision',
]);

Route::get('/seller/sellerAccount', [
    'uses' => '\App\Http\Controllers\Seller\SellerAccountController@sellerAccount',
    'as' => 'sellerAccount',
]);

Route::get('/seller/editProfile', [
    'uses' => '\App\Http\Controllers\Seller\SellerAccountController@editProfileSeller',
    'as' => 'editProfileSeller',
]);
Route::post('/seller/editProfile', [
    'uses' => '\App\Http\Controllers\Seller\SellerAccountController@postEditProfileSeller',
]);

Route::get('/seller/changeSellerPassword', [
    'uses' => '\App\Http\Controllers\Seller\SellerAccountController@changeSellerPassword',
    'as' => 'changeSellerPassword',
]);
Route::post('/seller/changeSellerPassword', [
    'uses' => '\App\Http\Controllers\Seller\SellerAccountController@postChangeSellerPassword',
]);



////////////////////////////////chats/////////////////////////////////////////////////////////////

//Route::get('/chat', function (){
//    broadcast(new WebsocketDemoEvent('some data'));
//    return view('chat');
//});

Route::get('/chats', [
    'uses' => '\App\Http\Controllers\FirebaseController@index',
    'as' => 'chats',
]);
Route::post('/sendMessage/{order_id}/{buyer_id}/{buyer_name}/{seller_id}/{seller_name}/{sender}', [
    'uses' => '\App\Http\Controllers\FirebaseController@sendMessage',
]);
Route::get('/getChat/{order_id}', [
    'uses' => '\App\Http\Controllers\FirebaseController@getChat',
    'as' => 'getChat',
]);

//Route::get('/chat/getChat', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@getChat',
//]);
//
//Route::get('/messages', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@fetchMessages',
//]);
//Route::post('/messages', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@sendMessage',
//]);
//
//Route::get('/chats/{sender}/{id}', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@index',
//    'as' => 'chats',
//]);
//Route::post('/chat/getChat/{sender}/{receiver_id}/{sender_id}', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@getChat',
//]);
//
//Route::post('/chat/sendChat', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@sendChat',
//]);
//Route::post('/buyer/messages', [
//    'uses' => '\App\Http\Controllers\Buyer\BuyerChatsController@sendMessages',
//]);

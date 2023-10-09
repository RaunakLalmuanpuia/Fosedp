<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationMovementController;
use App\Http\Controllers\ApplicationStatusController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssociatedUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ConstituencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DistrictApplicationController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\FormElevenController;
use App\Http\Controllers\FormFiveController;
use App\Http\Controllers\FormUploadController;
use App\Http\Controllers\IncomingApplicationController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OutgoingApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceivedApplicationController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityController;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    $notices = Notice::query()
        ->where('published', true)
        ->get();
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'authenticated' => Auth::check(),
        'notices'=>$notices
    ]);
})->name('home');

Route::get('login', [AuthController::class,'create'])->name('login');
Route::post('login', [AuthController::class,'store'])->name('login.store');
Route::get('logout', [AuthController::class,'logout'])->name('login.destroy')->middleware('auth');

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['prefix' => 'util', 'middleware' => 'auth'], function () {
    Route::get('abilities', [UtilityController::class, 'abilities'])->name('util.abilities');
});


Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class,'create'])->name('dashboard');
    Route::resource('constituency', ConstituencyController::class);
    Route::resource('user', UserController::class)->middleware('role:admin');
    Route::resource('district', DistrictController::class);
    Route::resource('trade', TradeController::class);
    Route::resource('department', DepartmentController::class)->middleware('role:admin');;
    Route::resource('office', OfficeController::class);
    Route::resource('notice', NoticeController::class)->middleware('role:admin');
    Route::resource('associated-user', AssociatedUserController::class);


    Route::delete('district/{constituency}/detach', [ConstituencyController::class, 'detach'])->name('constituency.detach');
    Route::delete('department/{trade}/detach', [TradeController::class, 'detach'])->name('trade.detach');

    Route::post('trade/{trade}/subtrade', [TradeController::class,'storeSubtrade'])->name('trade.subtrade.store');
    Route::delete('trade/{subTrade}/detach', [TradeController::class,'detachSubTrade'])->name('trade.subtrade.detach');

    Route::prefix('option')->group(function () {
        Route::get('{district}/constituencies',[OptionController::class,'constituencies'])->name('option.district.constituencies');
        Route::get('{department}/trades',[OptionController::class,'departmentTrades'])->name('option.department.trades');
        Route::get('trades',[OptionController::class,'trades'])->name('option.trades');
        Route::get('{trade}/subtrades',[OptionController::class,'subTrades'])->name('option.trade.subtrades');

        Route::get('executive-users',[OptionController::class,'executiveUsers'])->name('option.executive-users');
        Route::get('department-users',[OptionController::class,'departmentUsers'])->name('option.department-users');
        Route::get('planning-users',[OptionController::class,'planningUsers'])->name('option.planning-users');
        Route::get('dc-users',[OptionController::class,'dcUsers'])->name('option.dc-users');
        Route::get('dc-verifiers',[OptionController::class,'dcVerifiers'])->name('option.dc-verifiers');
        Route::get('dc-approvals',[OptionController::class,'dcApprovals'])->name('option.dc-approvals');
        Route::get('associated-user',[OptionController::class,'associatedUsers'])->name('option.associated-users');
        Route::get('users',[OptionController::class,'users'])->name('option.users');
    })->middleware(['auth']);

    Route::get('bank', [BankAccountController::class,'index'])->name('bank.index')->middleware(['role:admin']);
    Route::get('bank/create', [BankAccountController::class,'create'])->name('bank.create')->middleware(['role:admin']);
    Route::post('bank/verify', [BankAccountController::class,'verify'])->name('bank.verify')->middleware(['role:admin']);


    Route::prefix('assignment')->group(function () {
        Route::post('{department}/assign', [AssignmentController::class, 'assignDepartment'])
            ->name('assignment.department');
        Route::delete('{department}/{user}/detach', [AssignmentController::class, 'detachDepartmentUser'])
            ->name('assignment.department.detach-user');
    });
});

Route::group(['prefix' => 'application', 'middleware' => 'auth'], function () {
    Route::get('index', [ApplicationController::class,'index'])->name('application.index');
    Route::get('create', [ApplicationController::class,'create'])->name('application.create');
    Route::post('store', [ApplicationController::class,'store'])->name('application.store');
    Route::put('{model}/update', [ApplicationController::class,'update'])->name('application.update');
    Route::get('received', [ReceivedApplicationController::class,'index'])->name('application.received');
    Route::get('outgoing', [OutgoingApplicationController::class,'index'])->name('application.outgoing');
    Route::get('district', [DistrictApplicationController::class,'index'])->name('application.district');
    Route::get('excel-reports', [ExcelExportController::class,'index'])->name('application.excel-report');
    Route::get('district/all', [DistrictApplicationController::class,'all'])->name('application.district.all');

    Route::get('{model}/show', [ApplicationController::class,'show'])->name('application.show');
    Route::get('{model}/edit', [ApplicationController::class,'edit'])->name('application.edit');
    Route::delete('{model}/destroy', [ApplicationController::class,'destroy'])->name('application.destroy');

    Route::get('incoming', [IncomingApplicationController::class,'index'])->name('application.incoming');
    Route::post('bulk-take', [IncomingApplicationController::class,'bulkTake'])->name('application.bulk-take');
    Route::post('{model}/send-back', [IncomingApplicationController::class,'sendBack'])->name('application.send-back');
    Route::post('bulk-verify', [ReceivedApplicationController::class,'bulkVerify'])->name('application.bulk-verify');
    Route::post('bulk-send-back', [ReceivedApplicationController::class,'bulkSendBack'])->name('application.bulk-send-back');
    Route::post('bulk-approve', [ReceivedApplicationController::class,'bulkApprove'])->name('application.bulk-approve');
    Route::post('bulk-planning-verify', [ReceivedApplicationController::class,'bulkPlanningVerify'])->name('application.bulk-planning-verify');
    Route::post('bulk-planning-approve', [ReceivedApplicationController::class,'bulkPlanningApprove'])->name('application.bulk-planning-approve');
    Route::post('bulk-board-approve', [ReceivedApplicationController::class,'bulkBoardApprove'])->name('application.bulk-board-approve');
    Route::post('bulk-executive-approve', [ReceivedApplicationController::class,'bulkExecutiveApprove'])->name('application.bulk-executive-approve');

    Route::put('{model}/status', [ApplicationStatusController::class,'updateStatus'])->name('application.update-status');

    Route::prefix('movement')->group(function () {
        Route::post('forward',[ApplicationMovementController::class,'forward'])->name('application.forward');
        Route::delete('{model}/revert',[ApplicationMovementController::class,'revert'])->name('application.revert');
        Route::put('bulk-revert',[ApplicationMovementController::class,'bulkRevert'])->name('application.bulk-revert');
        Route::put('{model}/take',[ApplicationMovementController::class,'take'])->name('application.take');
    });
    Route::prefix('task-group-user')->group(function () {
        Route::get('',[TaskGroupController::class,'index'])->name('task-group-user.index');
        Route::get('create',[TaskGroupController::class,'create'])->name('task-group-user.create');
        Route::post('',[TaskGroupController::class,'store'])->name('task-group-user.store');
        Route::get('{user}',[TaskGroupController::class,'edit'])->name('task-group-user.edit');
        Route::delete('{user}',[TaskGroupController::class,'destroy'])->name('task-group-user.destroy');
        Route::put('{user}',[TaskGroupController::class,'update'])->name('task-group-user.update');
    });

});
Route::group(['prefix'=>'monitory'],function (){


    Route::prefix('form-upload')->group(function () {
        Route::get('five-one',[FormUploadController::class,'fiveOne'])->middleware(['role:department'])->name('form-upload-five-one.index');
        Route::get('five-two',[FormUploadController::class,'fiveTwo'])->middleware(['role:department'])->name('form-upload-five-two.index');
        Route::get('six',[FormUploadController::class,'six'])->middleware(['role:department'])->name('form-upload-six.index');
        Route::get('seven',[FormUploadController::class,'seven'])->middleware(['role:department'])->name('form-upload-seven.index');
        Route::get('eight',[FormUploadController::class,'eight'])->middleware(['role:department'])->name('form-upload-eight.index');
        Route::get('nine',[FormUploadController::class,'nine'])->middleware(['role:department'])->name('form-upload-nine.index');
        Route::get('ten',[FormUploadController::class,'ten'])->middleware(['role:department'])->name('form-upload-ten.index');
        Route::get('eleven',[FormUploadController::class,'eleven'])->middleware(['role:department'])->name('form-upload-eleven.index');

        Route::get('five-one/create',[FormUploadController::class,'createFiveOne'])->middleware(['role:department'])->name('form-upload-five-one.create');
        Route::get('five-two/create',[FormUploadController::class,'createFiveTwo'])->middleware(['role:department'])->name('form-upload-five-two.create');
        Route::get('six/create',[FormUploadController::class,'createSix'])->middleware(['role:department'])->name('form-upload-six.create');
        Route::get('seven/create',[FormUploadController::class,'createSeven'])->middleware(['role:department'])->name('form-upload-seven.create');
        Route::get('eight/create',[FormUploadController::class,'createEight'])->middleware(['role:department'])->name('form-upload-eight.create');
        Route::get('nine/create',[FormUploadController::class,'createNine'])->middleware(['role:department'])->name('form-upload-nine.create');
        Route::get('ten/create',[FormUploadController::class,'createTen'])->middleware(['role:department'])->name('form-upload-ten.create');
        Route::get('eleven/create',[FormUploadController::class,'createEleven'])->middleware(['role:department'])->name('form-upload-eleven.create');

        Route::post('{name}',[FormUploadController::class,'store'])->middleware(['role:department'])->name('form-upload.store');
        Route::delete('{form}',[FormUploadController::class,'destroy'])->middleware(['role:department'])->name('form-upload.destroy');

        Route::get('five-one/all',[FormUploadController::class,'allFiveOne'])->middleware(['role:admin|planning'])->name('form-upload-five-one.all');
        Route::get('five-two/all',[FormUploadController::class,'allFiveTwo'])->middleware(['role:admin|planning'])->name('form-upload-five-two.all');
        Route::get('six/all',[FormUploadController::class,'allSix'])->middleware(['role:admin|planning'])->name('form-upload-six.all');
        Route::get('seven/all',[FormUploadController::class,'allSeven'])->middleware(['role:admin|planning'])->name('form-upload-seven.all');
        Route::get('eight/all',[FormUploadController::class,'allEight'])->middleware(['role:admin|planning'])->name('form-upload-eight.all');
        Route::get('nine/all',[FormUploadController::class,'allNine'])->middleware(['role:admin|planning'])->name('form-upload-nine.all');
        Route::get('ten/all',[FormUploadController::class,'allTen'])->middleware(['role:admin|planning'])->name('form-upload-ten.all');
        Route::get('eleven/all',[FormUploadController::class,'allEleven'])->middleware(['role:admin|planning'])->name('form-upload-eleven.all');
    });

});

Route::group(['prefix' => 'json', 'middleware' => 'auth'], function () {
    Route::get('movement/{model}', [JsonController::class,'movementHistory'])->name('json.movement.history');
    Route::get('user/{user}/perms', [JsonController::class,'userPerms'])->name('json.user.perms');
    Route::get('{application}/audits', [ApplicationController::class,'getAudits'])->name('json.application.audit');
});
Route::group(['prefix' => 'master-data',], function () {
    Route::get('all', [MasterDataController::class,'masterData'])->name('masterData.all');
});

Route::group(['prefix' => 'statistic', 'middleware' => 'auth'], function () {
    Route::get('trade-district', [StatisticController::class,'tradeDistrictWise'])->name('statistic.trade-district');
    Route::get('department-trade', [StatisticController::class,'departmentTrade'])->name('statistic.trade-department');
    Route::get('constituency-wise', [StatisticController::class,'constituencyApplications'])->name('statistic.application.constituency');
});
Route::group(['prefix' => 'export', 'middleware' => 'auth'], function () {
    Route::get('incoming-applications', [ExcelExportController::class,'exportIncomingApplication'])->name('export.incoming-application');
    Route::get('received-applications', [ExcelExportController::class,'exportReceivedApplication'])->name('export.received-application');
    Route::get('district-applications', [ExcelExportController::class,'exportDistrictApplication'])->name('export.district-application');
});
Route::get('test/queue/{mobile}', [TestController::class,'testQueue']);
Route::get('sms/{offset}/{limit}', [SmsController::class,'send']);


//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryRecordController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingDeliveryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseSectionController;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('reports');

Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'userLogin'])->name('login');

Route::get('/register', [AuthController::class, 'register'])
    ->can('create', User::class);

Route::post('/register', [AuthController::class, 'userRegister'])
    ->name('register')
    ->can('create', User::class);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')
        ->name('users')
        ->can('viewAny', User::class);

    Route::post('/user/add', 'store')
        ->name('users_store')
        ->can('create', User::class);

    Route::get('/user/edit/{user}', 'edit')
        ->name('users_edit')
        ->can('update', User::class);

    Route::post('/user/edit/{user}', 'update')
        ->name('users_update')
        ->can('update', User::class);

    Route::get('/user/delete/{user}', 'delete')
        ->name('users_delete')
        ->can('delete', User::class);

    Route::get('/user/destroy/{user}', 'destroy')
        ->name('users_destroy')
        ->can('view', User::class);

    Route::get('/user/attendance/{user}', 'attendanceRecords')
        ->name('users_attendance')
        ->can('view', User::class);
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/order', 'index')
        ->name('orders')
        ->can('create', User::class);

    Route::get('/order/add', 'create')
        ->name('order_add')
        ->can('create', User::class);

    Route::post('/order/add', 'store')
        ->name('order_store')
        ->can('create', User::class);

    Route::post('/order/stage/{product}/add', 'stageAdd')
        ->name('order_stage_add')
        ->can('create', User::class);

    Route::post('/order/stage/{product}/sub', 'stageSub')
        ->name('order_stage_sub')
        ->can('create', User::class);

    Route::get('/order/delete/{order}', 'delete')
        ->middleware('auth')
        ->name('order_delete');

    Route::get('/order/destory/{order}', 'destroy')
        ->can('update', User::class)
        ->name('order_destroy');

    Route::get('/order/itemview/{order}', 'itemView')
        ->middleware('auth')
        ->name('item_view');

    Route::get('/order/deliver', 'deliveries')
        ->middleware('auth')
        ->name('deliveries');

    Route::post('/order/deliver/{order}', 'deliver')
        ->middleware('auth')
        ->name('order_deliver');

    Route::get('/delivery/add/{order}', 'createDelivery')
        ->middleware('auth')
        ->name('delivery_add');

    Route::get('/delivery/success', 'deliveriesSuccess')
        ->middleware('auth')
        ->name('deliveries_success');

    Route::get('/delivery/proof/{order}', 'deliveryProof')
        ->middleware('auth')
        ->name('delivery_proof');
});

Route::controller(IncomingDeliveryController::class)->group(function() {
    Route::get('/incoming', 'index')
        ->name('incoming')
        ->can('viewAny', User::class);

    Route::get('/incoming/add', 'create')
        ->name('incoming_add')
        ->can('create', User::class);

    Route::post('/incoming/add', 'store')
        ->name('incoming_store')
        ->can('create', User::class);
    
    Route::get('/incoming/deliver/{delivery}', 'success')
        ->name('incoming_deliver')
        ->can('update', User::class);

    Route::get('/incoming/cancel/{delivery}', 'cancel')
        ->name('incoming_cancel')
        ->can('update', User::class);
});

Route::controller(EmployeeAttendanceController::class)->group(function () {
    Route::get('/attendance', 'index')
        ->name('employee_attendance')
        ->can('viewAny', User::class);

    Route::get('/attendance/add', 'create')
        ->name('attendance_add')
        ->can('create', User::class);

    Route::post('/attendance/add', 'store')
        ->name('attendance_store')
        ->can('create', User::class);

    Route::get('/attendance/timeout/{attendance}', 'timeout')
        ->name('attendance_add_timeout')
        ->can('update', User::class);

    Route::post('/attendance/timeout/{attendance}', 'addTimeout')
        ->name('attendance_store_timeout')
        ->can('update', User::class);
});

Route::controller(InventoryController::class)->group(function () {
    Route::get('/inventory', 'index')
        ->name('inventory')
        ->can('viewAny', User::class);

    Route::get('/inventory/add', 'create')
        ->name('inventory_add')
        ->can('create', User::class);

    Route::post('/inventory/add', 'store')
        ->name('inventory_store')
        ->can('create', User::class);

    Route::get('/inventory/edit/{inventory}', 'edit')
        ->name('inventory_edit')
        ->can('update', User::class);

    Route::post('/inventory/edit/{inventory}', 'update')
        ->name('inventory_update')
        ->can('update', User::class);

    Route::get('/inventory/delete/{inventory}', 'delete')
        ->name('inventory_delete')
        ->can('delete', User::class);

    Route::get('/inventory/destroy/{inventory}', 'destroy')
        ->name('inventory_destroy')
        ->can('update', User::class);
});

Route::controller(WarehouseController::class)->group(function () {
    Route::get('/warehouse', 'index')
        ->name('warehouse')
        ->can('viewAny', Warehouse::class);

    Route::get('/warehouse/add', 'create')
        ->name('warehouse_add')
        ->can('create', Warehouse::class);

    Route::post('/warehouse/add', 'store')
        ->name('warehouse_store')
        ->can('create', Warehouse::class);
});

Route::controller(WarehouseSectionController::class)->group(function () {
    Route::get('/warehouse/item/{product}', 'itemSections')
        ->middleware('auth')
        ->name('item_sections');

    Route::get('/warehouse/{warehouse}/section', 'index')
        ->name('warehouse_section')
        ->can('viewAny', Warehouse::class);

    Route::get('/warehouse/{warehouse}/section/add', 'create')
        ->name('warehouse_section_add')
        ->can('create', Warehouse::class);

    Route::post('/warehouse/{warehouse}/section/add', 'store')
        ->name('warehouse_section_store')
        ->can('create', Warehouse::class);

    Route::get('/warehouse/{warehouse}/section/delete/{warehouseSection}', 'delete')
        ->name('warehouse_section_delete')
        ->can('delete', Warehouse::class);

    Route::get('/warehouse/{warehouse}/section/destroy/{warehouseSection}', 'destroy')
        ->name('warehouse_section_destroy')
        ->can('delete', Warehouse::class);
});

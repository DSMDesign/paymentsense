<?php

use Illuminate\Support\Facades\Route;
use Dsm\PaymentSense\Controllers\DemoPaymentSensePac;

// Demo routes ONLY FOR TESTING PURPOSES
Route::group([
    'middleware' => ['web'],
], function () {
    Route::controller(DemoPaymentSensePac::class)->group(function () {
        // List all the machines
        Route::get('/payment-sense/demo', 'index')
            ->name('paymentSense.demo');
        // Start a transaction
        Route::post('/payment-sense/transaction-start', 'startTransaction')
            ->name('paymentSense.transaction-start');
        // Display the transaction information
        Route::get(
            '/payment-sense/transaction-information/{requestId}/{machineId}',
            'getTransactionInformation'
        )->name('paymentSense.transaction-information');
        // Delete the transaction so we have a clear machine
        Route::get(
            '/payment-sense/transaction-cancel/{requestId}/{machineId}',
            'cancelTransaction'
        )->name('paymentSense.transaction-cancel');
        // Z index Report
        Route::get(
            '/payment-sense/machine-total/{machineId}',
            'getMachineTotal'
        )->name('paymentSense.machine-total');
    });
});

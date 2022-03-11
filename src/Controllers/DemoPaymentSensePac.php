<?php

namespace Dsm\PaymentSense\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Dsm\PaymentSense\Helpers\PaymentSensePac;
use Illuminate\Validation\ValidationException;

/**
 * This class will be use only for the demo once live you can disable this in the config file
 *
 * [Description DemoPaymentSensePac]
 */
class DemoPaymentSensePac extends Controller
{
    /**
     * Return the machines avaliable for this location based in the api keys
     *
     */
    public function index()
    {
        $paymentSense = new PaymentSensePac();
        $getTerminals = $paymentSense->listPacTerminals();

        return view('payment-sense::content.index', compact('getTerminals'));
    }

    /**
     * This method is used to start a transaction
     * @param Request $request
     *
     * @return [type]
     */
    public function startTransaction(Request $request)
    {
        $request->validate([
            'transactionType' => 'required', // Once live make sure validate for the right fields
            'amount'          => 'required', // Once live make sure validate for the right fields
            'amountCashback'  => 'required', // Once live make sure validate for the right fields
            'currency'        => 'required', // Once live make sure validate for the right fields
        ]);

        // Start the helper class for the PAC
        $paymentSense = new PaymentSensePac();
        // Payload in the form field we goin to use to tell the machice what to do
        // More information please check https://docs.connect.paymentsense.cloud/rest/api
        $payload = [
            'transactionType' => Request('transactionType'),
            'amount'          => Request('amount'),
            'amountCashback'  => Request('amountCashback'),
            'currency'        => Request('currency')
        ];
        // Start the transaction and get the response so we can use it in the view
        $transactionInformation = $paymentSense->startPacMachineTransaction(Request('machine_id'), $payload);

        if ($transactionInformation['status'] == false) {
            throw ValidationException::withMessages(['Machine id not valid or connection not valid']);
        } else {
            $machineId = Request('machine_id');
            return view('payment-sense::content.transaction', compact('transactionInformation', 'machineId'));
        }
    }

    /**
     * This function will get the transaction information
     *
     * @param Request $request
     * @param mixed $id
     *
     */
    public function getTransactionInformation(Request $request, $requestId, $machineId)
    {
        // Start the helper class for the PAC
        $paymentSense = new PaymentSensePac();
        // Call the method to get the transaction information
        $getTransactionInformation = $paymentSense->getTransactionStatus($machineId, $requestId);

        if ($getTransactionInformation['status'] == false) {
            throw ValidationException::withMessages(['Machine id or Request id not valid.']);
        } else {
            return view('payment-sense::content.transaction_info', compact('getTransactionInformation', 'machineId', 'requestId'));
        }
    }

    /**
     * Cancel the transaction and redirect to the index page
     *
     * @param Request $request
     * @param mixed $requestId
     * @param mixed $machineId
     *
     * @return [type]
     */
    public function cancelTransaction(Request $request, $requestId, $machineId)
    {
        // Start the helper class for the PAC
        $paymentSense = new PaymentSensePac();
        $requestInfo  = $paymentSense->cancelTransaction($machineId, $requestId);

        // If error we display the data
        if ($requestInfo['status'] == false) {
            dd($requestInfo, 'error');
        } else {
            return redirect()->route('paymentSense.demo');
        }
    }

    /**
     * This method will return the machice id selected totals
     *
     * @param Request $request
     * @param mixed $machineId
     *
     */
    public function getMachineTotal(Request $request, $machineId)
    {
        // Start the helper class for the PAC
        $paymentSense   = new PaymentSensePac();

        // Avaliable report types END_OF_DAY, BANKING, X_BALANCE, Z_BALANCE
        $type = Request('END_OF_DAY') ?? 'END_OF_DAY';

        // We goin to cache the request for this machine for 20 minutes so we don't overload the request
        $machineRequest = Cache::remember('machine_total' . $machineId . $type, 1200, function ()
        use ($paymentSense, $machineId, $type) {
            $machineRequest = $paymentSense->startMachineTotalRequest($machineId);
            return $machineRequest;
        });
        // Wait 2 seconds to get the information
        sleep(2);
        // If error we display the message
        if ($machineRequest['status'] == false) {
            dd($machineRequest['data']['messages'], 'error');
        } else {
            // If success we display the total
            $machineTotals  = $paymentSense->getRequestTotalZindex($machineId, $machineRequest['data']['requestId']);
            dd($machineTotals, 'success');
        }
    }
}

<?php

namespace Dsm\PaymentSense\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dsm\PaymentSense\Helpers\PaymentSencePac;
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
        $paymentSence = new PaymentSencePac();
        $getTerminals = $paymentSence->listPacTerminals();

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
        $paymentSence = new PaymentSencePac();
        // Payload in the form field we goin to use to tell the machice what to do
        // More information please check https://docs.connect.paymentsense.cloud/rest/api
        $payload = [
            'transactionType' => Request('transactionType'),
            'amount'          => Request('amount'),
            'amountCashback'  => Request('amountCashback'),
            'currency'        => Request('currency')
        ];
        // Start the transaction and get the response so we can use it in the view
        $transactionInformation = $paymentSence->startPacMachineTransaction(Request('machine_id'), $payload);

        if ($transactionInformation['status'] == false) {
            throw ValidationException::withMessages(['Machine id not valid or connection not valid']);
        } else {
            $machineId = Request('machine_id');
            return view('payment-sense::content.transaction', compact('transactionInformation', 'machineId'));
        }
    }

    /**
     * This fuction will get the transaction information
     *
     * @param Request $request
     * @param mixed $id
     *
     */
    public function getTransactionInformation(Request $request, $requestId, $machineId)
    {
        // Start the helper class for the PAC
        $paymentSence = new PaymentSencePac();
        // Call the method to get the transaction information
        $getTransactionInformation = $paymentSence->getTransactionStatus($machineId, $requestId);

        if ($getTransactionInformation['status'] == false) {
            throw ValidationException::withMessages(['Machine id or Request id not valid.']);
        } else {
            return view('payment-sense::content.transaction_info', compact('getTransactionInformation'));
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
        $paymentSence  = new PaymentSencePac();
        $machineTotals = $paymentSence->getMachineEndOfDayTotal($machineId);
        dd($machineTotals);
    }
}

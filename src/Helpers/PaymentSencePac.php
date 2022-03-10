<?php

namespace Dsm\PaymentSense\Helpers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

/**
 * This Class will be use to manage the PAC machines using the payment sence API
 * More information: https://docs.connect.paymentsense.cloud/rest/api
 */
class PaymentSencePac
{
    public function __construct()
    {
        // End point for the payment sence api
        $this->end_point = 'https://' . config('paymentsense.end_point');
        // Api key in this case is a password for bais authentication
        $this->api_key   = config('paymentsense.api_key');
        // User name
        $this->api_user  = config('paymentsense.api_user');
    }

    /**
     * This fuction will be the base request to the PAC machines
     *
     * @param mixed $urlSection
     *
     * @return Http [object]
     */
    private function baseRequest()
    {
        return Http::withBasicAuth($this->api_user, $this->api_key);
    }

    /**
     * Return all the object Response in the same format
     *
     * @param Response $response
     *
     * @return [json]
     */
    private function handleResponce(Response $response)
    {
        if ($response->successful()) {
            return [
                'status'        => true,
                'data'          => $response->json(),
                'responce_code' => $response->status(),
            ];
        } else {
            return [
                'status'        => false,
                'data'          => $response->json(),
                'responce_code' => $response->status(),
            ];
        }
    }

    /**
     * This Fuction will return all the api location avaliable PAC machines
     *
     * @return Json [json]
     */
    public function listPacTerminals()
    {
        return $this->handleResponce(
            $this->baseRequest()->get($this->end_point . '/pac/terminals')
        );
    }

    /**
     * Return the specific PAC machine information
     * @param mixed $id
     *
     * @return Json [json]
     */
    public function getPacMachineInformation($tid)
    {
        return $this->handleResponce(
            $this->baseRequest()->get($this->end_point . '/pac/terminals/' . $tid)
        );
    }

    /**
     * Send a transaction to the PAC machine
     *
     * @param mixed $tid
     * @param mixed $transactionSale
     *
     */
    public function startPacMachineTransaction($tid, $transactionSale)
    {
        return $this->handleResponce(
            $this->baseRequest()
                ->post($this->end_point . '/pac/terminals/' . $tid . '/transactions', $transactionSale)
        );
    }

    /**
     * Get the information about the transaction we have created
     *
     * @param mixed $tid
     * @param mixed $requestId
     *
     */
    public function getTransactionStatus($tid, $requestId)
    {
        return $this->handleResponce(
            $this->baseRequest()
                ->get($this->end_point . '/pac/terminals/' . $tid . '/transactions/' . $requestId)
        );
    }

    /**
     * This Fuction will delete the transaction we have created
     *
     * @param mixed $tid
     * @param mixed $transactionSale
     *
     */
    public function cancelTransaction($tid, $requestId)
    {
        return $this->handleResponce(
            $this->baseRequest()
                ->delete($this->end_point . '/pac/terminals/' . $tid . '/transactions/' . $requestId)
        );
    }

    /**
     * Aceept the transaction signature
     *
     * @param mixed $tid
     * @param mixed $requestId
     *
     */
    public function acceptSignature($tid, $requestId)
    {
        return $this->handleResponce(
            $this->baseRequest()
                ->patch($this->end_point . '/pac/terminals/' . $tid . '/transactions/' . $requestId . '/signature')
        );
    }

    /**
     * Get the machine end of the day transactions
     *
     * @param mixed $id
     *
     */
    public function startMachineTotalRequest($tid)
    {
        // Start the machine request so for the z index total and return the index
        $request = $this->handleResponce(
            $this->baseRequest()
                ->post($this->end_point . '/pac/terminals/' . $tid . '/reports', [
                    'reportType' => 'END_OF_DAY',
                ])
        );

        return $request;
    }

    /**
     * This fuction will return the total report for that machine based in the request
     * @param mixed $tid
     * @param mixed $requestId
     *
     * @return Json [json]
     */
    public function getRequestTotalZindex($tid, $requestId)
    {
        // Get te machine total not that it takes some time to get the total so we will wait for a while
        $reportHistory = $this->handleResponce(
            $this->baseRequest()
                ->get($this->end_point . '/pac/terminals/' . $tid . '/reports/' . $requestId)
        );

        return $reportHistory;
    }
}

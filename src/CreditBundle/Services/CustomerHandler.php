<?php
namespace CreditBundle\Services;

use CreditBundle\Entity\Customer;

class CustomerHandler
{
    private $remoteUrl;
    private $postType;
    private $defaultData;
    private $scoreMap;
    private $defaultScore;

    public function __construct($remoteUrl, $postType, $defaultData, $scoreMap, $defaultScore)
    {
        $this->remoteUrl    = $remoteUrl;
        $this->postType     = $postType;
        $this->defaultData  = $defaultData;
        $this->scoreMap     = $scoreMap;
        $this->defaultScore = $defaultScore;
    }

    /**
     * Get data (array). Prepare data for 3rd party service.
     * Send data to fake 3rd party service. Analyze and prepare response.
     *
     * @param array $data
     * @return mixed
     */
    public function checkRemoteData(array $data)
    {
        $data = $this->prepareData($data);

        $response = $this->sendCurlRequest($data);

        return $this->reactToResponse($response);
    }

    /**
     * If there are no real data - Vasya Pupkin is our candidate.
     *
     * @param array $data
     * @return array
     */
    private function prepareData(array $data)
    {
        // use given data, or default customer data
        $data = !empty($data) ? $data : $this->defaultData;

        // replace credit score with actual value according to our rules
        $data['creditScore'] = $this->scoreMap[$data['creditScore']] ?: $this->defaultScore;

        return ['userInfo' => $data];
    }

    /**
     * Get customer. Prepare customer data for 3rd party service.
     * Send data to fake 3rd party service. Analyze and prepare response.
     *
     * @param Customer $customer
     * @return mixed
     */
    public function checkCustomer(Customer $customer)
    {
        $data = $this->prepareCustomerData($customer);

        $response = $this->sendCurlRequest($data);

        return $this->reactToResponse($response);
    }


    /**
     * Prepare customer data for 3rd party API
     *
     * @param Customer $customer
     * @return array
     */
    private function prepareCustomerData(Customer $customer)
    {
        $data = [
            'firstName'     => $customer->getFirstName(),
            'lastName'      => $customer->getLastName(),
            'dateOfBirth'   => $customer->getDateOfBirth()->format('Y-m-d'),
            'Salary'        => $customer->getSalary(),
            'creditScore'   => $customer->getCreditScore(),
        ];

        return $this->prepareData($data);
    }

    /**
     * Analyze 3rd party service response.
     * Do some actions according to results.
     *
     * @param $remoteResponse
     * @return array
     */
    private function reactToResponse($remoteResponse)
    {
        if (empty($remoteResponse['SubmitDataResult'])) {
            return [
                'SubmitDataResult'          => 'failed',
                'SubmitDataErrorMessage'    => 'Broken answer from 3rd party service. Check API.'
            ];
        }

        switch ($remoteResponse['SubmitDataResult']) {
            case 'success':
                // do smth with success result
                break;
            case 'reject':
                // do smth with reject result
                break;
            case 'error':
                // do smth with error result
                break;
            default:
                // unexpectable status
                break;
        }

        return $remoteResponse;
    }


    /**
     * Send data to fake 3rd party service. Analyze and prepare response.
     *
     * @param array $data
     * @return array
     */
    private function sendCurlRequest(array $data) {
        $ch = curl_init($this->remoteUrl);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: {$this->postType}"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }
}

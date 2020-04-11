<?php

namespace CreditBundle\Controller;

use CreditBundle\Services\CustomerHandler;
use CreditBundle\Util\CreditApiInterface;
use CreditBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/credit")
 */
final class CustomerController extends Controller implements CreditApiInterface
{
    /**
     * Get json data. Send it to 3rd party service. Check result status.
     *
     * @param Request $request
     *
     * @Route("/customer", methods={"GET", "POST"}, name="check_data")
     *
     * @return Response
     */
    public function checkDataAction(Request $request)
    {
        /** @var CustomerHandler $customerHandler */
        $customerHandler = $this->get('credit.customer_handler');

        $data = json_decode(utf8_encode($request->getContent()), true);

        // Send data to 3rd party credit service and get result.
        $result = $customerHandler->checkRemoteData($data);

        return json_encode($result);
    }

    /**
     * Get data from db by customer id. Send it to 3rd party service. Check result status.
     *
     * @param integer $customerId
     *
     * @Route("/customer/{customerId}", methods={"GET"}, name="check_customer", requirements={"customerId"="\d+"} )
     *
     * @return Response
     * @throws \Exception
     */
    public function checkCustomerAction($customerId)
    {
        $customer = $this->getDoctrine()->getRepository('CreditBundle:Customer')->find($customerId);

        if (!$customer instanceof Customer) {
            throw new \Exception('Customer not found');
        }

        /** @var CustomerHandler $customerHandler */
        $customerHandler = $this->get('credit.customer_handler');

        // Send data to 3rd party credit service and get result.
        $result = $customerHandler->checkCustomer($customer);

        return $this->render(
            '@Credit/Customer/CreditResult.html.twig',
            [
                'response' => $result,
                'customer' => $customer
            ]
        );
    }
}

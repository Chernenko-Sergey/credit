<?php

namespace CreditBundle\Util;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

interface CreditApiInterface
{
    /**
     * @param Request $request
     *
     * @Route(methods={"POST"})
     *
     * @return Response
     */
    public function checkDataAction(Request $request);

    /**
     * @param integer $customerId
     *
     * @Route(methods={"GET"})
     *
     * @return Response
     */
    public function checkCustomerAction(integer $customerId);
}
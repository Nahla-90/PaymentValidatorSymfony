<?php
namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\Mobile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatorController extends BaseController
{
    /**
     * * Created By Nahla Sameh
     * @Route(
     *     "/validate",
     *      methods={"POST"}
     *     )
     * Validate Credit cards according to request data
     */
    static function validate(Request $request)
    {
        try {
            /* Check if request authorized*/
            if (parent::isAuthorized()) {

                /* Get request paymentType*/
                $paymentType = $request->get('paymentType',"");

                /* Check paymentType if it is creditCard */
                if ($paymentType === 'creditCard') {

                    /* Set CreditCard Data from $_POST array */
                    $creditCard = new CreditCard();
                    $creditCard->setCreditCardNumber($request->get('creditCardNumber',""));
                    $creditCard->setEmail($request->get('email',""));
                    $creditCard->setExpirationDate($request->get('expirationDate',""));
                    $creditCard->setCvv2($request->get('cvv2',""));

                    /* Prepare response array with validation result and errors */
                    $responseData = array('valid' => $creditCard->isValid(), 'errors' => $creditCard->getValidationErrors());
                } elseif ($paymentType === 'mobile') { /* Check paymentType if it is mobile */

                    /* Set Mobile Data from $_POST array */
                    $mobile = new Mobile();
                    $mobile->setPhoneNumber($request->get('phoneNumber',""));

                    /* Prepare response array with validation result and errors*/
                    $responseData = array('valid' => $mobile->isValid(), 'errors' => $mobile->getValidationErrors());
                } else {
                    /* enter here when have not valid payment type */

                    /* Prepare response array */
                    $responseData = array('valid' => false, 'errors' => array("Invalid Payment Type"));
                }

                /* Get response format from request data*/
                $responseFormat = $request->get('format',"json");
                if ($responseFormat === 'xml') {

                    /* prepare response with xml format*/

                    return new Response(Parent::prepareXmlResponse($responseData));
                } elseif ($responseFormat === 'json') {

                    /* prepare response with json format*/
                    return new JsonResponse($responseData, 200);

                } else {
                    /* prepare response with json format*/
                    $responseData = array('valid' => false, 'errors' => array("Invalid Response format"));
                    return new JsonResponse($responseData, 200);
                }
            } else {
                /* If Not authorized request it will return invalid request with json format*/
                $responseData = array('valid' => false, 'errors' => array("Invalid Request"));
                return new JsonResponse($responseData, 200);
            }
        } catch (Exception $exception) {
            /* If any issue happend then back with error message*/
            $responseData = array('valid' => false, 'errors' => array("Sorry, Something went wrong!"));
            return new JsonResponse($responseData, 200);
        }
    }
}

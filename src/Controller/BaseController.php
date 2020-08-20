<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{
    /**
     * Created By Nahla Sameh
     * Authorize any request using request hash
     * @param $requestTimestamp
     * @param $requestKey
     * @return bool
     */
    public function isAuthorized()
    {
        try {
            /* prepare requestHash from $requestTimestamp&$requestKey*/
            $requestHash = $_SERVER['HTTP_TIMESTAMP'] . $_SERVER['HTTP_KEY'];

            /* Get Current Time stamp */
            $timestamp = date_timestamp_get(date_create());
            $apiKey = "abcd";

            /*Prepare authorizedHash */
            $authorizedHash = $timestamp . $apiKey;

            /*check if $requestHash is equal $authorizedHash*/
            if ($authorizedHash === $requestHash) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $exception){
            /* If any issue happend then back with error message*/
            return false;
        }
    }

    /**
     * Created By Nahla Sameh
     * Prepare Response in Json Format
     * @param $responseData
     * @return false|string
     */
    public function prepareJsonResponse($responseData)
    {
        return json_encode($responseData);
    }

    /**
     * Created By Nahla Sameh
     * Prepare Response in Xml Format
     * @param $responseData
     * @return string
     */
    public function prepareXmlResponse($responseData)
    {
        /* Start xmlString with xml tag */
        $xmlString = '<?xml version="1.0"?>';

        /* Loop on response data array */
        foreach ($responseData as $key => $value) {

            /* if value is array then loop on its inner values to add to xmlString*/
            if (is_array($value)) {

                /* append inner values start tag to xmlString */
                $xmlString .= '<' . $key . '>';

                /* loop on inner values to add to xmlString */
                foreach ($value as $innerValue) {
                    $keyTmp = substr_replace($key, "", -1);
                    $xmlString .= '<' . $keyTmp . '>' . $innerValue . '</' . $keyTmp . '>';
                }

                /* append inner values end tag to xmlString */
                $xmlString .= '</' . $key . '>';
            } else {
                /* if Values is normal "not array" then append it to xmlString*/
                $xmlString .= '<' . $key . '>' . var_export($value, true) . '</' . $key . '>';
            }
        }

        /* Return xmlString */
        return $xmlString;
    }
}

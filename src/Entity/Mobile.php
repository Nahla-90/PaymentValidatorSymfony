<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validation;

class Mobile
{
    private $phoneNumber;
    private $validationErrors = array();

    /**
     * Created By Nahla Sameh
     * @param $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Created By Nahla Sameh
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Created By Nahla Sameh
     * Check if current Object of Mobile Payment is valid
     * @return bool
     */
    public function isValid()
    {
        $validator = Validation::createValidator();

        /* Validate PhoneNumber*/
        $filteredPhoneNumber = filter_var($this->phoneNumber, FILTER_SANITIZE_NUMBER_INT);
        $phoneNumberToCheck = str_replace("-", "", $filteredPhoneNumber);
        $violations = $validator->validate($phoneNumberToCheck, [new NotBlank(),new Positive(),new Length(['min'=>10,'max'=>14])]);
        foreach ($violations as $violation) {
            $this->validationErrors[] = "Phone Number ".$violation->getMessage();
        }

        /* Return true if no validation errors found*/
        if(count($this->validationErrors)>0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Created By Nahla Sameh
     * @return array
     */
    public function getValidationErrors(){
        return$this->validationErrors;
    }
}

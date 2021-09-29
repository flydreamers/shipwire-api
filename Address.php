<?php

namespace mataluis2k\shipwire;

class Address
{
    public $address1='';
    public $address2='';
    public $address3='';
    public $city='';
    public $postalCode='';
    public $region='';
    public $country='';
    public $isCommercial=0;
    public $isPoBox=0;


    /**
     * Serialize this info as array
     * @return array
     */
    public function asArray()
    {
        return [
            'address1' => $this->address1,
            'address2' => $this->address2,
            'address3' => $this->address3,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'region' => $this->region,
            'country' => $this->country,
            'isCommercial' => $this->isCommercial,
            'isPoBox' => $this->isPoBox,
        ];
    }

    /**
     * Serialize this info as json
     * @return string
     */
    public function asJson(){
        return json_encode($this->asArray());
    }

    /**
     * Creates an address from an array
     * @param $arr
     * @return Address
     */
    public static function createFromArray($arr)
    {
        $ret = new Address();
        foreach ($arr as $key => $value) {
            if (property_exists($ret, $key)){
                $ret->$key = $value;
            }
        }
        return $ret;
    }
}
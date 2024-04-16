<?php
/**
 * NOTICE OF LICENSE
 * Title   : DigitalFemsa Cash Payment Gateway for Prestashop
 * Author  : DigitalFemsa.io
 * URL     : https://www.digitalfemsa.io/es/docs/plugins/prestashop.
 * PHP Version 7.0.0
 * DigitalFemsa File Doc Comment
 *
 * @author    DigitalFemsa <support@digitalfemsa.io>
 * @copyright 2024 DigitalFemsa
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @category  DigitalFemsa
 *
 * @version   GIT: @2.3.7@
 *
 * @see       https://digitalfemsa.io/
 */

namespace DigitalFemsa;

class Address extends DigitalFemsaResource
{
    public $street1 = '';

    public $street2 = '';

    public $street3 = '';

    public $city = '';

    public $state = '';

    public $zip = '';

    public $country = '';

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __isset($property)
    {
        return isset($this->$property);
    }
}

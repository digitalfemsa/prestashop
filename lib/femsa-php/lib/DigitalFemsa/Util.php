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

abstract class Util
{
    public static $types = [
    'webhook' => '\DigitalFemsa\Webhook',
    'webhook_log' => '\DigitalFemsa\WebhookLog',
    'billing_address' => '\DigitalFemsa\Address',
    'cash_payment' => '\DigitalFemsa\PaymentMethod',
    'charge' => '\DigitalFemsa\Charge',
    'customer' => '\DigitalFemsa\Customer',
    'event' => '\DigitalFemsa\Event',
    'payment_source' => '\DigitalFemsa\PaymentSource',
    'tax_line' => '\DigitalFemsa\TaxLine',
    'shipping_line' => '\DigitalFemsa\ShippingLine',
    'discount_line' => '\DigitalFemsa\DiscountLine',
    'digital_femsa_list' => '\DigitalFemsa\DigitalFemsaList',
    'shipping_contact' => '\DigitalFemsa\ShippingContact',
    'lang' => '\DigitalFemsa\Lang',
    'line_item' => '\DigitalFemsa\LineItem',
    'order' => '\DigitalFemsa\Order',
    ];

    public static function convertToDigitalFemsaObject($resp)
    {
        $types = self::$types;

        if (is_array($resp)) {
            if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
                $instance = new $class();
                $instance->loadFromArray($resp);

                return $instance;
            }

            if (isset($resp['street1']) || isset($resp['street2'])) {
                $class = '\DigitalFemsa\Address';
                $instance = new $class();
                $instance->loadFromArray($resp);

                return $instance;
            }

            if (current($resp)) {
                $instance = new DigitalFemsaObject();
                $instance->loadFromArray($resp);

                return $instance;
            }

            return new DigitalFemsaObject();
        }

        return $resp;
    }

    public static function shiftArray($array, $object)
    {
        unset($array[$object]);
        end($array);
        $lastKey = key($array);

        for ($i = $object; $i < $lastKey; ++$i) {
            $array[$i] = $array[$i + 1];
            unset($array[$i + 1]);
        }

        return $array;
    }
}

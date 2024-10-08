<?php
/**
 * NOTICE OF LICENSE
 * Title   : DigitalFemsa Cash Payment Gateway for Prestashop
 * Author  : DigitalFemsa.io
 * URL     : https://digital-femsa.readme.io/docs/prestashop-1.
 * PHP Version 7.0.0
 * DigitalFemsa File Doc Comment
 *
 * @author    DigitalFemsa <monitoreo.b2b@digitalfemsa.com>
 * @copyright 2024 DigitalFemsa
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @category  DigitalFemsa
 *
 * @version   GIT: @2.3.7@
 *
 * @see       https://digitalfemsa.io/
 */

/**
 * Class Config
 */
class DigitalFemsaConfig
{
    public static function getLineItems($items = '')
    {
        $lineItems = [];

        foreach ($items as $item) {
            $lineItems = array_merge($lineItems, [
                [
                    'name' => $item['name'],
                    'unit_price' => (int) ((float) $item['price'] * 100),
                    'quantity' => (int) $item['cart_quantity'],
                    'tags' => ['prestashop'],
                    ],
                ]);

            if (Tools::strlen($item['reference']) > 0) {
                array_merge($lineItems, [
                    [
                        'sku' => $item['reference'],
                        ],
                    ]);
            }

            if (Tools::strlen($item['description_short']) > 2) {
                array_merge($lineItems, [
                    [
                        'description' => $item['reference'],
                        ],
                    ]);
            }
        }

        return $lineItems;
    }

    public static function getTaxLines($items = '')
    {
        $tax_lines = [];

        foreach ($items as $item) {
            $tax = (int) round(((float) $item['total_wt'] - (float) $item['total']) * 100);

            if (!empty($item['tax_name'])) {
                $tax_lines = array_merge($tax_lines, [
                    [
                        'description' => $item['tax_name'],
                        'amount' => $tax,
                        ],
                    ]);
            }
        }

        return $tax_lines;
    }

    public static function getDiscountLines($discounts)
    {
        $discount_lines = [];

        if (!empty($discounts)) {
            foreach ($discounts as $discount) {
                $discount_lines = array_merge(
                    $discount_lines,
                    [
                        [
                            'code' => (string) $discount['name'],
                            'amount' => str_replace(',', '', number_format($discount['value_real'] * 100)),
                            'type' => 'coupon',
                        ],
                    ]
                );
            }
        }

        return $discount_lines;
    }

    public static function getShippingLines($shipping_service, $shipping_carrier = '', $shipping_price = '')
    {
        $shipping_price = str_replace(',', '', number_format($shipping_price * 100));
        $shipping_lines = [
            [
                'amount' => $shipping_price,
                'tracking_number' => $shipping_service,
                'carrier' => $shipping_carrier,
                'method' => $shipping_service,
                ],
            ];

        return $shipping_lines;
    }

    public static function getShippingContact($customer = '', $address_delivery = '', $state = '', $country = '')
    {
        $shipping_contact = [
            'receiver' => $customer->firstname . ' ' . $customer->lastname,
            'phone' => $address_delivery->phone,
            'address' => [
                'street1' => $address_delivery->address1,
                'city' => $address_delivery->city,
                'state' => $state,
                'country' => $country,
                'postal_code' => $address_delivery->postcode,
                ],
            'metadata' => ['soft_validations' => true],
            ];

        return $shipping_contact;
    }

    public static function getCustomerInfo($customer = '', $address_delivery = '')
    {
        $customer_info = [
            'name' => $customer->firstname . ' ' . $customer->lastname,
            'phone' => $address_delivery->phone,
            'email' => $customer->email,
            'metadata' => ['soft_validations' => true],
            ];

        return $customer_info;
    }
}

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

class PaymentSource extends ConektaResource
{
    public const TYPE_CARD = 'card';

    public const TYPE_OXXO_RECURRENT = 'oxxo_recurrent';

    public function instanceUrl()
    {
        $this->apiVersion = Conekta::$apiVersion;
        $id = $this->id;
        parent::idValidator($id);
        $class = get_class($this);
        $base = '/payment_sources';
        $extn = urlencode($id);
        $customerUrl = $this->customer->instanceUrl();

        return $customerUrl . $base . "/{$extn}";
    }

    public function update($params = null)
    {
        return parent::_update($params);
    }

    public function delete()
    {
        return parent::_delete('customer', 'payment_sources');
    }

    /**
     * Method for determine if is card
     *
     * @return bool
     */
    public function isCard()
    {
        return $this['type'] == self::TYPE_CARD;
    }

    /**
     * Method for determine if is oxxo recurrent
     *
     * @return bool
     */
    public function isOxxoRecurrent()
    {
        return $this['type'] == self::TYPE_OXXO_RECURRENT;
    }
}

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

namespace DigitalFemsa\Payments\UseCases;

use Tools;
use Validate;

class ValidateAdminForm
{
    public function __invoke(array $orderAttributes, array $productAttributes): array
    {
        $arrayErrors = [];

        if (empty(Tools::getValue('DIGITAL_FEMSA_PUBLIC_KEY_TEST'))
            || !Validate::isString(Tools::getValue('DIGITAL_FEMSA_PUBLIC_KEY_TEST'))) {
            $arrayErrors[] = 'The "Test Public Key" field is required.';
        }

        if (empty(Tools::getValue('DIGITAL_FEMSA_PUBLIC_KEY_LIVE'))
            || !Validate::isString(Tools::getValue('DIGITAL_FEMSA_PUBLIC_KEY_LIVE'))) {
            $arrayErrors[] = 'The "Live Public Key" field is required.';
        }

        if (empty(Tools::getValue('DIGITAL_FEMSA_PRIVATE_KEY_TEST'))
            || !Validate::isString(Tools::getValue('DIGITAL_FEMSA_PRIVATE_KEY_TEST'))) {
            $arrayErrors[] = 'The "Test Private Key" field is required.';
        }

        if (empty(Tools::getValue('DIGITAL_FEMSA_PRIVATE_KEY_LIVE'))
            || !Validate::isString(Tools::getValue('DIGITAL_FEMSA_PRIVATE_KEY_LIVE'))) {
            $arrayErrors[] = 'The "Live Private Key" field is required.';
        }

        if (empty(Tools::getValue('DIGITAL_FEMSA_WEBHOOK'))
            || !Validate::isAbsoluteUrl(Tools::getValue('DIGITAL_FEMSA_WEBHOOK'))) {
            $arrayErrors[] = 'The "Webhook" field is required or must be an url';
        }

        if (empty(Tools::getValue('DIGITAL_FEMSA_METHOD_CASH'))) {
            $arrayErrors[] = 'You need select almost one payment method.';
        }

        $digitalFemsaExpirationDateLimit = (int) Tools::getValue('DIGITAL_FEMSA_EXPIRATION_DATE_LIMIT');
        $digitalFemsaExpirationDateType = (int) Tools::getValue('DIGITAL_FEMSA_EXPIRATION_DATE_TYPE');

        if (!empty(Tools::getValue('DIGITAL_FEMSA_METHOD_CASH'))
            && empty($digitalFemsaExpirationDateLimit)) {
            $arrayErrors[] = 'The "Expiration date limit" field is required.';
        }

        if (!empty(Tools::getValue('DIGITAL_FEMSA_METHOD_CASH'))
            && !Validate::isInt($digitalFemsaExpirationDateLimit)) {
            $arrayErrors[] = 'The "Expiration date limit" must be a number.';
        }

        if (!empty(Tools::getValue('DIGITAL_FEMSA_METHOD_CASH'))
            && $digitalFemsaExpirationDateType === 0
            && ($digitalFemsaExpirationDateLimit < 0 || $digitalFemsaExpirationDateLimit > 31)) {
            $arrayErrors[] = 'The "Expiration date limit" is out of range. must be a number between 0 and 31';
        }

        if (!empty(Tools::getValue('DIGITAL_FEMSA_METHOD_CASH'))
            && $digitalFemsaExpirationDateType === 1
            && ($digitalFemsaExpirationDateLimit < 0 || $digitalFemsaExpirationDateLimit > 24)) {
            $arrayErrors[] = 'The "Expiration date limit" is out of range. must be a number between 0 and 24';
        }

        $productAttributesFiltered = array_filter($productAttributes, function ($attribute) {
            $key = sprintf('PRODUCT_%s', Tools::strtoupper($attribute));

            return !empty(Tools::getValue($key));
        });

        $orderAttributesFiltered = array_filter($orderAttributes, function ($attribute) {
            $key = sprintf('ORDER_%s', Tools::strtoupper($attribute));

            return !empty(Tools::getValue($key));
        });

        if ((count($productAttributesFiltered) + count($orderAttributesFiltered)) > DIGITAL_FEMSA_METADATA_LIMIT) {
            $arrayErrors[] = 'No more than 12 ("Additional Order Metadata" or "Additional Product Metadata") attributes can be sent as metadata';
        }

        return $arrayErrors;
    }
}

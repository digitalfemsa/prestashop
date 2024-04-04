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
if (!function_exists('curl_init')) {
    throw new Exception('DigitalFemsa needs the CURL PHP extension.');
}

if (!function_exists('json_decode')) {
    throw new Exception('DigitalFemsa needs the JSON PHP extension.');
}

if (!function_exists('mb_detect_encoding')) {
    throw new Exception('DigitalFemsa needs the Multibyte String PHP extension.');
}

if (!function_exists('get_called_class')) {
    throw new Exception('DigitalFemsa needs to be run on PHP >= 5.3.0.');
}

require_once dirname(__FILE__) . '/DigitalFemsa/Lang.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Conekta.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Util.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Requestor.php';

require_once dirname(__FILE__) . '/DigitalFemsa/ConektaObject.php';

require_once dirname(__FILE__) . '/DigitalFemsa/ConektaResource.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Charge.php';

require_once dirname(__FILE__) . '/DigitalFemsa/PaymentMethod.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Customer.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Token.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Event.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Method.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Address.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Webhook.php';

require_once dirname(__FILE__) . '/DigitalFemsa/WebhookLog.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Log.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Order.php';

require_once dirname(__FILE__) . '/DigitalFemsa/PaymentSource.php';

require_once dirname(__FILE__) . '/DigitalFemsa/TaxLine.php';

require_once dirname(__FILE__) . '/DigitalFemsa/DiscountLine.php';

require_once dirname(__FILE__) . '/DigitalFemsa/ShippingLine.php';

require_once dirname(__FILE__) . '/DigitalFemsa/LineItem.php';

require_once dirname(__FILE__) . '/DigitalFemsa/ConektaList.php';

require_once dirname(__FILE__) . '/DigitalFemsa/ShippingContact.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/Handler.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/ApiError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/AuthenticationError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/MalformedRequestError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/NoConnectionError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/ParameterValidationError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/ProcessingError.php';

require_once dirname(__FILE__) . '/DigitalFemsa/Exceptions/ResourceNotFoundError.php';

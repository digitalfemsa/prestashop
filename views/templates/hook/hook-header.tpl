{**
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
 * @category  DigitalFemsa
 * @version   GIT: @2.3.7@
 * @see       https://digitalfemsa.io/
 *}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.min.js"></script>
<script type="text/javascript" src="https://cdn.conekta.io/iframe/latest/conekta-iframe.js"></script> 
<script type="text/javascript" src="https://pay.conekta.com/v1.0/js/conekta-checkout.min.js"></script> 
<script type="text/javascript" src="{$path|escape:'htmlall':'UTF-8'}views/js/tokenize.js"></script>


<script type="text/javascript">
	var conekta_public_key = "{$api_key|escape:'htmlall':'UTF-8'}";
	var conekta_checkout_id = "{$checkoutRequestId|escape:'htmlall':'UTF-8'}";
	var conekta_order_id = "{$orderID|escape:'htmlall':'UTF-8'}";
	var conekta_amount = "{$amount|escape:'htmlall':'UTF-8'}";
</script> 

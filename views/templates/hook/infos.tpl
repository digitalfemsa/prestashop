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
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<img src="../modules/oxxopay/logo.png" style="float:left; margin-right:15px;" width="60" height="60">
	<p><strong>{l s='This module allows you to accept payments by check.' d='Modules.Checkpayment.Admin' mod='conekta'}</strong></p>
	<p>{l s='If the client chooses this payment method, the order status will change to Waiting for payment.'  d='Modules.Checkpayment.Admin' mod='conekta'}</p>
	<p>{l s='You will need to manually confirm the order as soon as you receive a check.'  d='Modules.Checkpayment.Admin' mod='conekta'}</p>
</div>
{if !empty($error_webhook_message)}
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<p>{$error_webhook_message|escape:'htmlall':'UTF-8'}</p>
	</div>
{/if}
{if isset($config_check) && !$config_check}
	<div class="alert alert-danger">
		<strong>{$msg_show|escape:'htmlall':'UTF-8'}</strong>
		<ul style="margin-top: 10px;">
			{foreach key=key item=item from=$requirements}
				{if $key != 'result'}
					<li>{$item.name|escape:'htmlall':'UTF-8'}</li>
				{/if}
			{/foreach}
		</ul>
	</div>
{/if}

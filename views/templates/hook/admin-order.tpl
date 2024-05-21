{**
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
 * @category  DigitalFemsa
 * @version   GIT: @2.3.7@
 * @see       https://digitalfemsa.io/
 *}
<div class="col-md-12">
	<div class="panel">
		<h3><i class="icon-money"></i> {l s='Digital Femsa Payment Details' mod='digitalfemsa'}</h3>

		<ul class="nav nav-tabs" id="tabDigital Femsa">
			<li class="active">
				<a href="#digital_femsa_details">
					<i class="icon-money"></i> {l s='Details' mod='digitalfemsa'} <span class="badge">{$digital_femsa_tran_details.id_transaction|escape:'htmlall':'UTF-8'}</span>
				</a>
			</li>
		</ul>

		<div class="tab-content panel">
			<div class="tab-pane active" id="digital_femsa_details">
			{if isset($digital_femsa_tran_details.id_transaction)}
				<p>
					<strong>Status</strong> <span style="font-weight: bold; color: {$color_status|escape:'htmlall':'UTF-8'};">{$message_status|escape:'htmlall':'UTF-8'}</span>
					<br>
					<strong>{l s='Amount:' mod='digitalfemsa'}</strong> {$display_price|escape:'htmlall':'UTF-8'}
					<br>
					<strong>{l s='Processed on:' mod='digitalfemsa'}</strong> {$processed_on|escape:'htmlall':'UTF-8'}
					<br>
					<strong>{l s='Mode:' mod='digitalfemsa'}</strong> <span style="font-weight: bold; color: {$color_mode|escape:'htmlall':'UTF-8'}};">{$txt_mode|escape:'htmlall':'UTF-8'}</span>
				</p>
			{else}
				<span style="color: #CC0000;"><strong>{l s='Warning:' mod='digitalfemsa'}</strong></span> {l s='The customer paid using Digital Femsa and an error occured (check details at the bottom of this page)' mod='digitalfemsa'}
			{/if}
			</div>
		</div>
	</div>
</div>
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
{if isset($message)}
  <div class="digital-femsa-payment-errors" style="display:block;">{$message|escape:'htmlall':'UTF-8'}</div>
{/if}
{if isset($smarty.get.message)}
  <div class="digital-femsa-payment-errors" style="display:block;">{$smarty.get.message|escape:'htmlall':'UTF-8'}</div>
{/if}

<form action="{$action|escape:'htmlall':'UTF-8'}" id="digital-femsa-payment-form" method="post">

  {if !isset($message)}
      <div id="digitalFemsaIframeContainer" style="height:800px; width: 100%;"></div>
      <button style="display:none" id="digital-femsa-payment-resume" type="submit" class="btn btn-primary">resumen</button>
  {/if}

</form>

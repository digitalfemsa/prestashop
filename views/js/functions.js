/**
* @copyright  2024 DigitalFemsa
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author DigitalFemsa <monitoreo.b2b@digitalfemsa.com>
*  @version  v2.0.0
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$(document).ready(function () {
    //initial state
    let paymentCash = $("#DIGITAL_FEMSA_METHOD_CASH");
    let expirationDateLimit = $("#DIGITAL_FEMSA_EXPIRATION_DATE_LIMIT");
    let paymentCashChecked = paymentCash.is(":checked");

    $("#DIGITAL_FEMSA_EXPIRATION_DATE_TYPE_DAYS").prop("disabled", !paymentCashChecked);
    $("#DIGITAL_FEMSA_EXPIRATION_DATE_TYPE_HOURS").prop("disabled", !paymentCashChecked);
    expirationDateLimit.prop("disabled", !paymentCashChecked);

    //onchange value
    paymentCash.change(function () {
        $("#DIGITAL_FEMSA_EXPIRATION_DATE_TYPE_DAYS").prop("disabled", !this.checked);
        $("#DIGITAL_FEMSA_EXPIRATION_DATE_TYPE_HOURS").prop("disabled", !this.checked);
        expirationDateLimit.prop("disabled", !this.checked);
        expirationDateLimit.prop("required", this.checked);
    });

});

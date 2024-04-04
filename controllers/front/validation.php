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

/**
 * ConektaValidationModuleFrontController Class Doc Comment
 *
 * @author   Conekta <support@conekta.io>
 *
 * @category Class
 *
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see     https://conekta.com/
 */
class ConektaValidationModuleFrontController extends ModuleFrontController
{
    /**
     * Returns the module that the payment of the order was made.
     *
     * @return void
     */
    public function postProcess()
    {
        $cart = $this->context->cart;
        $authorized = false;
        $customer = new Customer($cart->id_customer);
        $conekta = new OxxoPay();

        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'conekta') {
                $authorized = true;

                break;
            }
        }

        if (!$authorized) {
            print_r($this->getTranslator()->trans(
                'This payment method is not available.',
                [],
                'Modules.DigitalFemsa.Shop'
            ));
        } else {
            if (!Validate::isLoadedObject($customer)) {
                Tools::redirect('index.php?controller=order&step=1');
            }

            $date = new DateTime();

            $order = (object) [
                'id' => pSQL(Tools::getValue('conektaOrdenID')),
                'amount' => pSQL(Tools::getValue('conektAmount')),
                'charges' => (object) [
                    'id' => pSQL(Tools::getValue('chargeId')),
                    'created_at' => pSQL(Tools::getValue('createAt')) ?
                        pSQL(Tools::getValue('createAt')) : $date->getTimestamp(),
                    'amount' => pSQL(Tools::getValue('conektAmount')),
                    'status' => pSQL(Tools::getValue('charge_status')),
                    'currency' => pSQL(Tools::getValue('charge_currency')),
                    'livemode' => Configuration::get('FEMSA_DIGITAL_MODE'),
                    'payment_method' => (object) [
                        'type' => pSQL(Tools::getValue('payment_type')),
                        'reference' => pSQL(Tools::getValue('reference')),
                    ],
                ],
                'plan_id' => pSQL(Tools::getValue('plan_id')),
            ];

            $conekta->processPayment($order);

            $this->setTemplate('module:conekta/views/templates/front/payment_return.tpl');
        }
    }
}

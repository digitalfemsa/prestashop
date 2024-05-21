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

namespace DigitalFemsa;

class Customer extends DigitalFemsaResource
{
    public $livemode = '';

    public $name = '';

    public $email = '';

    public $phone = '';

    public $defaultShippingContactId = '';

    public $defaultPaymentSourceId = '';

    public $referrer = '';

    public $accountAge = '';

    public $paidTransactions = '';

    public $firstPaidAt = '';

    public $corporate = '';

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __isset($property)
    {
        return isset($this->$property);
    }

    public function loadFromArray($values = null)
    {
        if (isset($values)) {
            parent::loadFromArray($values);
        }

        if (DigitalFemsa::$apiVersion == '2.0.0') {
            $submodels = [
        'payment_sources', 'shipping_contacts',
      ];

            foreach ($submodels as $submodel) {
                if (isset($values[$submodel])) {
                    $submodel_list = new DigitalFemsaList($submodel, $values[$submodel]);
                    $submodel_list->loadFromArray($values[$submodel]);
                    $this->$submodel->_values = $submodel_list;
                } else {
                    $submodel_list = new DigitalFemsaList($submodel, []);
                }
                $this->$submodel = $submodel_list;

                foreach ($this->$submodel as $object => $val) {
                    $val->customer = $this;
                }
            }
        } else {
            $submodels = ['cards'];

            foreach ($submodels as $submodel) {
                if (isset($this->$submodel)) {
                    $submodel_list = $this->$submodel;

                    foreach ($submodel_list as $object => $val) {
                        if (isset($val->deleted) != true) {
                            $val->customer = $this;
                            $this->$submodel->_setVal($object, $val);
                        }
                    }
                }
            }
        }

        if (isset($this->subscription)) {
            $this->subscription->customer = $this;
        }
    }

    public static function find($id)
    {
        $class = get_called_class();

        return parent::_scpFind($class, $id);
    }

    public static function where($params = null)
    {
        $class = get_called_class();

        return parent::_scpWhere($class, $params);
    }

    public static function create($params = null)
    {
        $class = get_called_class();

        return parent::_scpCreate($class, $params);
    }

    public function delete()
    {
        return parent::_delete();
    }

    public function update($params = null)
    {
        return parent::_update($params);
    }

    public function createPaymentSource($params = null)
    {
        return parent::_createMemberWithRelation('payment_sources', $params, $this);
    }

    public function deletePaymentSourceById($paymentSourceId)
    {
        if (DigitalFemsa::$apiVersion == '2.0.0') {
            $currentCustomer = $this;
            $paymentSources = $currentCustomer->payment_sources;
            $index = 0;

            foreach ($paymentSources as $paymentSource) {
                if ($paymentSource->id == $paymentSourceId) {
                    $currentCustomer->payment_sources[$index]->delete();
                } else {
                    ++$index;
                }
            }
        }
    }

    public function createCard($params = null)
    {
        return parent::_createMemberWithRelation('cards', $params, $this);
    }

    public function createSubscription($params = null)
    {
        return parent::_createMember('subscription', $params);
    }

    public function createShippingContact($params = null)
    {
        return parent::_createMemberWithRelation('shipping_contacts', $params, $this);
    }

    /**
     * @deprecated
     */
    public static function retrieve($id)
    {
        $class = get_called_class();

        return parent::_scpFind($class, $id);
    }

    public static function all($params = null)
    {
        $class = get_called_class();

        return parent::_scpWhere($class, $params);
    }
}

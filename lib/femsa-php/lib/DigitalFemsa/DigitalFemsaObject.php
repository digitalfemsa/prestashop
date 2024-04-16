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

use ArrayObject;

class DigitalFemsaObject extends ArrayObject
{
    protected $_values;

    public function __construct($id = null)
    {
        $this->_values = [];
        $this->id = $id;
    }

    public function _setVal($object, $val)
    {
        $this->_values[$object] = $val;
        $this[$object] = $val;
    }

    public function _unsetKey($object)
    {
        unset($this->_values[$object]);
        unset($object);
    }

    public function loadFromArray($values)
    {
        foreach ($values as $object => $val) {
            if (is_array($val)) {
                $val = Util::convertToDigitalFemsaObject($val);
            }

            if (strpos(get_class($this), 'DigitalFemsaObject') !== false) {
                $this[$object] = $val;
            } else {
                if (strpos($object, 'url') !== false && strpos(get_class($this), 'Webhook') !== false) {
                    $object = 'webhook_url';
                }
                $this->$object = $val;

                if ($object == 'metadata') {
                    $this->metadata = new DigitalFemsaObject();

                    if (is_array($val) || is_object($val)) {
                        foreach ($val as $object2 => $val2) {
                            $this->metadata->$object2 = $val2;
                            $this->metadata->_setVal($object2, $val2);
                        }
                    }
                }
            }
            $this->_setVal($object, $val);
        }
    }

    public function __toJSON()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode($this->_toArray(), JSON_PRETTY_PRINT);
        } else {
            return json_encode($this->_toArray());
        }
    }

    protected function _toArray()
    {
        $array = [];

        foreach ($this->_values as $object => $val) {
            if (is_object($val) == true && get_class($val) != '') {
                if (empty($val->_values) != true) {
                    $array[$object] = $val->_toArray();
                }
            } else {
                $array[$object] = $val;
            }
        }

        return $array;
    }

    public function __toString()
    {
        return $this->__toJSON();
    }

    public function offsetGet($offset)
    {
        return isset($this->_values[$offset]) ? $this->_values[$offset] : null;
    }
}

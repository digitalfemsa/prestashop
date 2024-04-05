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

class DigitalFemsaList extends DigitalFemsaObject
{
    public const LIMIT = 5;

    public function __construct($elements_type, $params = [])
    {
        parent::__construct();
        $this->elements_type = $elements_type;
        $this->params = $params;
        $this->total = 0;
    }

    public function addElement($element)
    {
        $element = Util::convertToFemsaDigitalObject($element);
        $this[$this->total] = $element;
        $this->_values[$this->total] = $element;
        $this->total = $this->total + 1;

        return $this;
    }

    public function loadFromArray($values = null)
    {
        if (isset($values)) {
            $this->has_more = $values['has_more'];
            $this->total = $values['total'];

            foreach ($this as $key => $value) {
                $this->_unsetKey($key);
            }
        }

        if (isset($values['data'])) {
            return parent::loadFromArray($values['data']);
        }
    }

    public function next($options = ['limit' => self::LIMIT])
    {
        if (sizeof($this) > 0) {
            $this->params['next'] = end($this)->id;
        }

        $this->params['previous'] = null;

        return $this->_moveCursor($options['limit']);
    }

    public function previous($options = ['limit' => self::LIMIT])
    {
        if (sizeof($this) > 0) {
            $this->params['previous'] = $this[0]->id;
        }

        $this->params['next'] = null;

        return $this->_moveCursor($options['limit']);
    }

    protected function _moveCursor($limit)
    {
        if (isset($limit)) {
            $this->params['limit'] = $limit;
        }

        $class = Util::$types[strtolower($this->elements_type)];
        $url = DigitalFemsaResource::classUrl($class);
        $requestor = new Requestor();
        $response = $requestor->request('get', $url, $this->params);

        return $this->loadFromArray($response);
    }
}

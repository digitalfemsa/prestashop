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

class Lang
{
    public const EN = 'en';

    public const ES = 'es';

    protected static $cache = [];

    public static function translate($key, $locale, $parameters = null)
    {
        $parameters = str_replace('DigitalFemsa\\', '', $parameters);

        $langs = self::readDirectory(dirname(__FILE__) . '/../locales/messages');

        $keys = explode('.', $locale . '.' . $key);
        $result = $langs[array_shift($keys)];

        foreach ($keys as $val) {
            $result = $result[$val];
        }

        if (is_array($parameters) && !empty($parameters)) {
            foreach ($parameters as $object => $val) {
                $result = str_replace($object, $val, $result);
            }
        }

        return $result;
    }

    protected static function readDirectory($directory)
    {
        if (!empty(self::$cache)) {
            return self::$cache;
        }

        $langs = [];

        if ($handle = opendir($directory)) {
            while ($lang = readdir($handle)) {
                if (strpos($lang, '.php') !== false) {
                    $langKey = str_replace('.php', '', $lang);
                    $langs[$langKey] = include $directory . '/' . $lang;
                }
            }

            closedir($handle);
        }

        self::$cache = $langs;

        return $langs;
    }
}

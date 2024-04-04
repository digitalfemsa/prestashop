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

abstract class Conekta
{
    public static $apiKey;

    public static $apiBase = 'https://api.conekta.io';

    public static $apiVersion = '2.0.0';

    public static $locale = 'es';

    public static $plugin = '';

    public static $pluginVersion = '';

    public const VERSION = '4.0.2';

    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    public static function setApiVersion($version)
    {
        self::$apiVersion = $version;
    }

    public static function setLocale($locale)
    {
        self::$locale = $locale;
    }

    public static function setPlugin($plugin = '')
    {
        self::$plugin = $plugin;
    }

    public static function setPluginVersion($pluginVersion = '')
    {
        self::$pluginVersion = $pluginVersion;
    }

    public static function getPlugin()
    {
        return self::$plugin;
    }

    public static function getPluginVersion()
    {
        return self::$pluginVersion;
    }
}

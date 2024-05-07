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

class Requestor
{
    public $apiKey;

    public function __construct()
    {
        $this->apiKey = DigitalFemsa::$apiKey;
        $this->apiVersion = DigitalFemsa::$apiVersion;
        $this->plugin = DigitalFemsa::$plugin;
    }

    /**
     * Function apiUrl
     *
     * get Base path of digitalfemsa api i.e. https://api.digitalfemsa.io
     *
     * @param url (string) endpoint to concatenate
     *
     * @return (string)
     */
    public static function apiUrl($url = '')
    {
        $apiBase = DigitalFemsa::$apiBase;

        return $apiBase . $url;
    }

    /**
     * Function additionalPluginHeaders
     *
     * Set headers if is plugin implementation
     *
     * @return (array)
     */
    private function additionalPluginHeaders()
    {
        return [
          'plugin_name' => DigitalFemsa::getPlugin(),
          'plugin_version' => DigitalFemsa::getPluginVersion(),
        ];
    }

    /**
     * Function setHeaders
     *
     * Set Standar headers for library
     *
     * @return (array)
     */
    private function setHeaders()
    {
        $pluginAgent = $this->additionalPluginHeaders();
        $userAgent = [
          'bindings_version' => DigitalFemsa::VERSION,
          'lang' => 'php',
          'lang_version' => phpversion(),
          'publisher' => 'digital_femsa',
          'uname' => php_uname(),
        ];

        if (array_filter($pluginAgent)) {
            $userAgent = array_merge($userAgent, $pluginAgent);
        }

        $headers = [
          'Accept: application/vnd.app-v' . DigitalFemsa::$apiVersion . '+json',
          'Accept-Language: ' . DigitalFemsa::$locale,
          'X-App-Client-User-Agent: ' . json_encode($userAgent),
          'User-Agent: App/v1 PhpBindings/' . DigitalFemsa::VERSION,
          'Authorization: Basic ' . base64_encode($this->apiKey . ':'),
          'Content-Type: application/json',
        ];

        return $headers;
    }

    /**
     * Function request
     *
     * Make api call
     *
     * @param method (string) REST action [DELETE,PUT,POST,GET]
     * @param url (string) endpoint to concatenate
     * @param params (array) contains body request
     *
     * @return (json)
     */
    public function request($method, $url, $params = null)
    {
        $jsonParams = json_encode($params);
        $headers = $this->setHeaders();
        $curl = curl_init();
        $method = strtolower($method);
        $opts = [];

        switch ($method) {
            case 'get':
                $opts[CURLOPT_HTTPGET] = 1;
                $url = $this->buildQueryParamsUrl($url, $params);

                break;

            case 'post':
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $jsonParams;

                break;

            case 'put':
                $opts[CURLOPT_RETURNTRANSFER] = 1;
                $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $opts[CURLOPT_POSTFIELDS] = $jsonParams;

                break;

            case 'delete':
                $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                $url = $this->buildSegmentParamsUrl($url, $params);

                break;

            default:
                throw new \Exception('Wrong method');
        }

        $url = $this->apiUrl($url);
        $opts[CURLOPT_URL] = $url;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = 30;
        $opts[CURLOPT_TIMEOUT] = 80;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_SSLVERSION] = 6;
        $opts[CURLOPT_CAINFO] = dirname(__FILE__) . '/../ssl_data/ca_bundle.crt';
        curl_setopt_array($curl, $opts);
        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $jsonResponse = json_decode($response, true);

        if ($responseCode != 200) {
            Handler::errorHandler($jsonResponse, $responseCode);
        }

        return $jsonResponse;
    }

    /**
     * Function buildQueryParamsUrl
     *
     * build body request into url
     *
     * @param url (string) endpoint to concatenate
     * @param params (array) contains body request
     *
     * @return (string)
     */
    private function buildQueryParamsUrl($url, $params)
    {
        if (!is_null($params)) {
            $params = http_build_query($params);
            $url = $url . '?' . $params;
        }

        return $url;
    }

    /**
     * Function buildSegmentParamsUrl
     *
     * build body request for DELETE  action
     *
     * @param url (string) endpoint to concatenate
     * @param params (array) contains body request
     *
     * @return (string)
     */
    private function buildSegmentParamsUrl($url, $params)
    {
        if (!is_array($params)) {
            $url = $url . urlencode($params);
        }

        return $url;
    }
}

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

namespace DigitalFemsa\Payments\UseCases;

require_once __DIR__ . '/../../lib/femsa-php/lib/Conekta.php';

use DigitalFemsa\Conekta;
use DigitalFemsa\Webhook;
use Configuration;
use Tools;

class CreateWebhook
{
    public const webhookSetting = 'FEMSA_DIGITAL_WEBHOOK';

    public const webhookFailedUrlSetting = 'FEMSA_DIGITAL_WEBHOOK_FAILED_URL';

    public const webhookErrorSetting = 'FEMSA_DIGITAL_WEBHOOK_ERROR_MESSAGE';

    public const webhookAttemptsSetting = 'FEMSA_DIGITAL_WEBHOOK_FAILED_ATTEMPTS';

    public const MaxFailedAttempts = 5;

    public function __invoke(
        bool $conektaMode,
        string $privateKey,
        string $isoCode,
        string $pluginVersion,
        string $oldWebhook
    ): bool {
        Conekta::setApiKey($privateKey);
        Conekta::setPlugin('Prestashop');
        Conekta::setApiVersion('2.0.0');
        Conekta::setPluginVersion($pluginVersion);
        Conekta::setLocale($isoCode);

        $events = ['events' => ['order.paid', 'order.expired']];

        $newWebhook = Tools::safeOutput(Tools::getValue(self::webhookSetting));
        Configuration::deleteByName(self::webhookErrorSetting);

        if ($oldWebhook === $newWebhook) {
            return true;
        }

        $failedAttempts = (int) Configuration::get(self::webhookAttemptsSetting);
        $failedWebhook = Configuration::get(self::webhookFailedUrlSetting);

        if ($newWebhook === $failedWebhook && $failedAttempts >= self::MaxFailedAttempts) {
            Configuration::updateValue(
                self::webhookErrorSetting,
                'Webhook register was fail some times, try changing webhook!'
            );
            Configuration::deleteByName(self::webhookAttemptsSetting);

            return false;
        }

        if ($failedAttempts < self::MaxFailedAttempts) {
            try {
                $webhooks = Webhook::where();

                $isWebhooksRegistered = array_filter((array) $webhooks, function ($webhook) use ($newWebhook) {
                    return $webhook->webhook_url === $newWebhook;
                });

                if (count($isWebhooksRegistered) <= 0) {
                    $mode = $conektaMode ? ['production_enabled' => 1] : ['development_enabled' => 1];
                    Webhook::create(array_merge(['url' => $newWebhook], $mode, $events));

                    Configuration::updateValue(self::webhookSetting, $newWebhook);

                    // delete error variables

                    Configuration::deleteByName(self::webhookAttemptsSetting);
                    Configuration::deleteByName(self::webhookFailedUrlSetting);
                    Configuration::deleteByName(self::webhookErrorSetting);
                }

                return true;
            } catch (\Exception $e) {
                ++$failedAttempts;
                Configuration::updateValue(self::webhookErrorSetting, $e->getMessage());
                Configuration::updateValue(self::webhookAttemptsSetting, $failedAttempts);
                Configuration::updateValue(self::webhookFailedUrlSetting, $newWebhook);

                return false;
            }
        }

        return true;
    }
}

Prestashop [1.7.8.x] Plugin v1.0.0
=======================
This plugin is an official and stable version of the DigitalFemsa Prestashop extension. It bundles functionality to process OXXO payments securely as well as send email notifications to your customers when they complete a successful purchase.

Don't worry about managing the status of your orders, the plugin will automatically changes orders to paid as long as your webhooks are properly configured.

Features
--------
Current version features:

*   Cash payments.
*   Automatic order status management.
*   Sandbox testing capability.

Installation
-----------

  Clone the module using 

```
git clone --recursive https://github.com/digitalfemsa/prestashop ./digitalfemsa
```

There is no custom installation for this plugin, just the default:

*   Compress the folder digital_femsa.
*   Go to the modules section and clic on 'Add a new module'.
*   Select the compressed folder.
*   Search for digital_femsa in the modules list.
*   Clic on 'install'.
*   Add your API keys.
*   Modify if necessary your webhook url.

License
-------
Developed by [DigitalFemsa](https://www.digitalfemsa.io). Available under [MIT License](LICENSE).

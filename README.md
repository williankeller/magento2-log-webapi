Log Web API transactions for Magento 2
=====================

This extension creates a log file and saves all transactions that are requested through your store's Rest API.

[![Build Status](https://travis-ci.org/magestat/magento2-log-webapi.svg?branch=develop)](https://travis-ci.org/magestat/magento2-log-webapi) [![Packagist](https://img.shields.io/packagist/v/magestat/module-log-webapi.svg)](https://packagist.org/packages/magestat/module-log-webapi)

## 1. Installation

### Install via composer (recommend)


Run the following command in Magento 2 root folder:
```sh
composer require magestat/module-log-webapi
```

### Using GIT clone

Run the following command in Magento 2 root folder:
```sh
git clone git@github.com:magestat/magento2-log-webapi.git app/code/Magestat/LogWebapi
```

## 2. Activation

Run the following command in Magento 2 root folder:
```sh
php bin/magento module:enable Magestat_LogWebapi --clear-static-content
php bin/magento setup:upgrade
```

Clear the caches:
```sh
php bin/magento cache:clean
```

## 3. Configuration

1. Go to **Stores** > **Configuration** > **Magestat** > **Log Webapi**.
2. Select **Enabled** option to enable the module.
3. Expand **Settings** Tab.
4. Fill the required fields.

## Contribution

Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


## Support

If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magestat/magento2-log-webapi/issues).

Need help setting up or want to customize this extension to meet your business needs? If we like your idea we will add this feature for free or at a discounted rate.

© Magestat

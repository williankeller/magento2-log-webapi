# Log Web API transactions for Magento 2

This extension creates a log file and saves all transactions that are requested through your store's Rest API.

[![Build Status](https://travis-ci.org/williankeller/magento2-log-webapi.svg?branch=develop)](https://travis-ci.org/williankeller/magento2-log-webapi)
[![Packagist](https://img.shields.io/packagist/v/magestat/module-log-webapi.svg)](https://packagist.org/packages/magestat/module-log-webapi)
[![Downloads](https://img.shields.io/packagist/dt/magestat/module-log-webapi.svg)](https://packagist.org/packages/magestat/module-log-webapi)

## Installation

### Install via composer (recommended)

Run the following command in your Magento 2 root folder:
```sh
composer require magestat/module-log-webapi
```

### Using GIT clone

Run the following command in yourMagento 2 root folder:
```sh
git clone git@github.com:williankeller/magento2-log-webapi.git app/code/Magestat/LogWebapi
```

## Activation

Run the following command in your Magento 2 root folder:
```sh
php bin/magento module:enable Magestat_LogWebapi
```
```sh
php bin/magento setup:upgrade
```

Clear the caches:
```sh
php bin/magento cache:clean
```

## Configuration

1. Go to **STORES** > **Configuration** > **MAGESTAT** > **Log Webapi**.
2. Select **Enabled** option to enable the module.
3. Expand **Settings** Tab.
4. Fill the required fields.

## Contribution

Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

## Support

If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/williankeller/magento2-log-webapi/issues).

Need help setting up or want to customize this extension to meet your business needs? Please open an issue and if we like your idea we will add this feature for free.


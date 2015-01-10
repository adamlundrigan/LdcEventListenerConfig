LdcEventListenerConfig
=============

---
[![Latest Stable Version](https://poser.pugx.org/adamlundrigan/ldc-event-listener-config/v/stable.svg)](https://packagist.org/packages/adamlundrigan/ldc-event-listener-config) [![Total Downloads](https://poser.pugx.org/adamlundrigan/ldc-event-listener-config/downloads.svg)](https://packagist.org/packages/adamlundrigan/ldc-event-listener-config) [![Latest Unstable Version](https://poser.pugx.org/adamlundrigan/ldc-event-listener-config/v/unstable.svg)](https://packagist.org/packages/adamlundrigan/ldc-event-listener-config) [![License](https://poser.pugx.org/adamlundrigan/ldc-event-listener-config/license.svg)](https://packagist.org/packages/adamlundrigan/ldc-event-listener-config)
[![Build Status](https://travis-ci.org/adamlundrigan/LdcEventListenerConfig.svg?branch=master)](https://travis-ci.org/adamlundrigan/LdcEventListenerConfig)
[![Code Coverage](https://scrutinizer-ci.com/g/adamlundrigan/LdcEventListenerConfig/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/adamlundrigan/LdcEventListenerConfig/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adamlundrigan/LdcEventListenerConfig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adamlundrigan/LdcEventListenerConfig/?branch=master)

---

## What?

LdcEventListenerConfig provides an easy mechanism for attaching listeners to the event manager via configuration 

## How?

1. Install the [Composer](https://getcomposer.org/) package:

    ```
    composer require adamlundrigan/ldc-event-listener-config:1.*@stable
    ```

2. Enable the module (`LdcEventListenerConfig`) in your ZF2 application.

3. Configure your event listeners ([example](demo/ExampleModule/Module.php#L49))

4. Profit!

## Show me!

If you're fortunate enough to be on a *nix system with PHP >=5.4, pop into the `demo` folder and run the setup script (`run.sh`).  This will build the demo application, install the example modules, and start a webserver.  Once that's all done just open your browser and navigate to `http://localhost:8080/` to see the result!


# Security.txt for Magento1 

This module creates a `security.txt`  file according to https://securitytxt.org/ and its [RFC](https://tools.ietf.org/html/rfc5785)

“When security risks in web services are discovered by independent security researchers who understand the severity of the risk, they often lack the channels to disclose them properly. As a result, security issues may be left unreported. security.txt defines a standard to help organizations define the process for security researchers to disclose security vulnerabilities securely.”

## Installation

### composer

``` 
composer require kkrieger85/magento-module-security-txt
```

### modman

```
modman init
modman clone https://github.com/kkrieger85/magento-module-security-txt.git
```

## Usage

1) enter configuration values
2) create `security.txt` file from Magento Backend 

If you don't enter any contact information the module uses contacts/email/recipient_email` setting


## Development

Please create PR on [Github](https://github.com/kkrieger85/magento-module-security-txt)

## Issues

Please create a new issue on [Github](https://github.com/kkrieger85/magento-module-security-txt/issues)

## License and author

* Author: Kevin Krieger (kk@kkrieger.de) 
* [GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

## Contributors
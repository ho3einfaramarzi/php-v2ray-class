# php-v2ray-class
this is a class for the x-ui panels api and work with clients
## Install

```bash
> composer require ho3einfaramarzi/php-v2ray-class --ignore-platform-reqs
```
## Requirements

The following versions of PHP are supported by this version.

* PHP 7.4

## Example Usage

```php
$x=new v2Ray("ho3ein.com","username","password");
$create=$x->create_client(1,"ho3ein",strtotime("+1 months") * 1000);
$link=$x->genVmess('ho3ein','39743f2c-ef79-4b20-ab27-c469eee4f699');
$stats=$x->get_client_stats("ho3ein");
$delete=$x->delete("ho3ein");

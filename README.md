# Dynamic Key

Dynamic Key is a PHP library returns a randomly-generated string that can be used for an encryption key. This library will return a key that will only be valid for a certain amount of time (1 hour by default) before a new key is generated. 

### Use Case
This library was designed for encrypting data and discarding the encryption key after a certain amount of time to prevent brute-forcing.

### Tech

Dynamic Key was designed for PHP 5. 

### Installation

Download dynamic_key.php, and wherever it is needed, write:

```php
include "dynamic_key.php";
```
#### Author
Brian Lam
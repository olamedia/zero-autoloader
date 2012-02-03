Usage
======

```php
<?php

use zero\classMapLoader;

classMapLoader::create(array(
	'className' => 'path/to/fileName.php',
	'className2' => 'path2/to/fileName2.php',
), __DIR__.'/path/to/src', 'namespace');

```

```php
<?php

use zero\namespaceLoader;

namespaceLoader::getInstance()->register(array(
'namespace1' => 'path/to/autoloader1.php',
'name\\space2' => 'path/to/autoloader2.php',
), __DIR__.'/path/to/src');

```

```php
<?php

use zero\prefixLoader;

prefixLoader::getInstance()->register(array(
'prefix1' => 'path/to/autoloader1.php',
'prefix2' => 'path/to/autoloader2.php',
), __DIR__.'/path/to/src');

```

```php
<?php

use zero\psr0Loader;

psr0Loader::getInstance()->register(array(
'prefix1' => 'path/to/src',
), __DIR__);

```

Simple APC Cache (key: prefix.className => value: filename)

```php
<?php

use zero\apcClassMapLoader;

apcClassMapLoader::create('prefix');

```

Nested autoloading example:


```php
<?php
use zero\prefixLoader;
prefixLoader::getInstance()->register(array(
'Twig' => 'Twig-1.5.1/zero-autoload.php',
'Zend' => 'ZendFramework-1.11.11-minimal/zero-autoload.php',
), __DIR__);
```

```php
<?php
// Twig-1.5.1/zero-autoload.php
use zero\psr0Loader;
psr0Loader::create(array(
	'Twig' => 'Twig-1.5.1/lib',
), __DIR__);
```

```php
<?php
// ZendFramework-1.11.11-minimal/zero-autoload.php
use zero\psr0Loader;
psr0Loader::create(array(
	'Zend' => 'library',
), __DIR__);
```


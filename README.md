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







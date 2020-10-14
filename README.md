# UKMDesignVanilla
 UKMDesign for Vanilla PHP-applikasjoner

## Installasjon
`$ composer require ukmnorge/designvanilla`

For å bruke den, må følgende kode inn

```php
<?php

use UKMNorge\Design\UKMDesign;
use UKMNorge\Design\Sitemap\Section;
use UKMNorge\TemplateEngine\Proxy\Twig;
use UKMNorge\TemplateEngine\Vanilla;

require_once('vendor/autoload.php');
require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

/**
 * Init Vanilla
 */
Vanilla::init(__DIR__);

// Set where we are
UKMDesign::setCurrentSection(
    new Section(
        'current',
        'https://url-something/',
        'Section-Title'
    )
);

// Do the magic

Vanilla::addViewData('key','val');
echo Vanilla::render('Template');
```

# UKMDesignVanilla
 UKMDesign for Vanilla PHP-applikasjoner

## Installasjon
- `$ composer require ukmnorge/designvanilla`
- Opprett mappen `Views`

For å bruke den, må følgende kode inn. Eksempelet krever at du oppretter en fil, `Template.html.twig` i `Views`-mappen.

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
Vanilla::init(__DIR__, __DIR__.'/cache/');

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

**Eksempel template-fil**
```twig
{% extends ("UKMDesign/Layout/base.html.twig")|UKMpath %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Velkommen</h1>
        </div>
   </div>
</div>
{% endblock %}
```

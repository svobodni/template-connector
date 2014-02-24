Svobodni template connector
==========================

Knihovna pro usnadnění generování šablony pro externí aplikace Svobodných.


Instalace pomocí composeru
--------------------------

**Pomocí composeru:** Přidejte do souboru `composer.json` tyto řádky:

```json
{
    "repositories": [
        { "type": "vcs", "url": "http://github.com/svobodni/template-connector" }
    ],
    "require": {
        "svobodni/template-connector": "*@dev"
    }
}
```

a spusťte:

```sh
composer update
```


Ruční instalace
---------------

- Stáhněte a rozbalte do projektu archiv z http://github.com/svobodni/website-connector
- zaregistrujte do projektu pomocí: `include __DIR__ . 'Svobodni/loader.php';`



Ukázka použití
--------------

```php
// include __DIR__ . '/Svobodni/loader.php';   # ruční instalace
include __DIR__ . '/vendor/autoload.php'; # instalace přes composer

$connector = new Svobodni\TemplateConnector;
// $connector->setCacheDir(__DIR__ . '/cache');
$connector->setParameter('title', 'Testovací titulek');
$connector->setParameter('content', 'Tady bude obsah');
$connector->render();
```


Testování
---------

```php
composer install --dev
vendor/bin/tester tests
```



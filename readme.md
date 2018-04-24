# Features

[![Build Status](https://travis-ci.org/wpup/features.svg?branch=master)](https://travis-ci.org/wpup/features)

WordPress admin settings page for [php-features](https://github.com/frozzare/php-features). That package is installed when using this plugin so no need to install it yourself.

## Install

```
composer require wpup/features
```

## Usage

First read [php-features](https://github.com/frozzare/php-features) readme file to know how that package works.

Example:

```php
features( [
    'log'      => false,
    'checkout' => true
] );
```

Best practice is the set features before WordPress are loaded, e.g config files.

## Filters

Add custom to description to features setting page:

```php
add_filter( 'features_description', function () {
    return 'my custom description';
} );
```

No HTML is allowed since the description is escaped.

Add custom labels to admin instead of feature keys:

```php
add_filter( 'features_labels', function () {
    return [
        'log' => 'Log'
    ];
} );
```

Change admin menu capability:

```php
add_filter( 'features_capability', function () {
    return 'custom-cap';
} );
```

## License

MIT © [Fredrik Forsmo](https://github.com/frozzare)

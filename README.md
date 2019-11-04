# didlogic-php
#### Didlogic API

## Installation

You can install it using [composer](https://getcomposer.org/). Run the following command in your project directory

    $ composer require pavelsc/didlogic-php:dev-master

or download the source.

## Usage Example

```
$client = new Didlogic\RestClient('your_key');
$countries = $client->countries()->getList();
foreach ($countries as $country) {
    $country->cities()->getList();
}
```

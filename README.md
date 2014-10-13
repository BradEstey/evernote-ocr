# Evernote OCR

This is an unofficial library for using the [Evernote](https://evernote.com) API as a means for image text recognition. Please be advised that using the Evernote API solely for the purpose of OCR for your application is a violation of the [API License Agreement](http://dev.evernote.com/documentation/reference/api_license.php).

## Installation

Install this package through Composer by editing your project's `composer.json` file to require `estey/evernote-ocr`.

``` json
{
    "require": {
        "estey/evernote-ocr": "0.1.*"
    }
}
``` 

Then, update Composer:

    composer update

To get a new Evernote Dev Token, sign in to your account and use this link: [https://www.evernote.com/api/DeveloperToken.action](https://www.evernote.com/api/DeveloperToken.action)

## Usage

``` php

use Estey\EvernoteOCR\Client;

$client = new Client('YOUR DEV TOKEN');
$response = $client->recognize('path/to/image.jpg');

print_r($response);

```

The recognize method will return an array of `TextBlock` objects, each with an array of text recognition options. Each `Text` object contains the recognized text and a confidence score of 0-100. Each `TextBlock` contains the X and Y coordinates where the text was found and the width and height of the text block in pixels.

    Array
    (
        [1] => Estey\EvernoteOCR\TextBlock Object
            (
                [x] => 51
                [y] => 82
                [width] => 307
                [height] => 35
                [options] => Array
                    (
                        [0] => Estey\EvernoteOCR\Text Object
                            (
                                [text] => SEPTEMBER
                                [confidence] => 91
                            )

                    )

            )

        [2] => Estey\EvernoteOCR\TextBlock Object
            (
                [x] => 370
                [y] => 87
                [width] => 128
                [height] => 30
                [options] => Array
                    (
                        [0] => Estey\EvernoteOCR\Text Object
                            (
                                [text] => 2014
                                [confidence] => 77
                            )

                        [1] => Estey\EvernoteOCR\Text Object
                            (
                                [text] => 201 a
                                [confidence] => 35
                            )

                    )

            )

    )

## Flysystem Adapter

The Evernote OCR package comes with a built in adapter to support the [Flysystem](http://flysystem.thephpleague.com) filesystem library.

``` php

use Estey\EvernoteOCR\Client;
use Estey\EvernoteOCR\FileAdapters\FlysystemFileAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

$filesystem = new Filesystem(new Adapter(__DIR__.'/path/to/root'));
$adapter = new FlysystemFileAdapter($filesystem);
$client = new Client('YOUR DEV TOKEN', $adapter);

print_r($client->recognize('path/to/image.jpg'));

```

## Laravel Filesystem Adapter

If you're using [Laravel](http://laravel.com), there is a service provider available. Open `app/config/app.php`, and add the service provider to the `providers` array. You'll also need to add your [Evernote Dev Token](https://www.evernote.com/api/DeveloperToken.action) to your `.env` file with the key set to `EVERNOTE_DEV_TOKEN`.

    'Estey\EvernoteOCR\Providers\Illuminate\EvernoteOCRServiceProvider'

Use it like so:

``` php

$client = App::make('evernote_ocr');
$response = $client->recognize('path/to/image.jpg');

print_r($response);

```

## Flysystem Adapter

The Evernote OCR package comes with a built in adapter to support the [Flysystem](http://flysystem.thephpleague.com) filesystem library.

``` php

use Estey\EvernoteOCR\Client;
use Estey\EvernoteOCR\FileAdapters\FlysystemFileAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

$filesystem = new Filesystem(new Adapter(__DIR__ . '/path/to/root'));
$adapter = new FlysystemFileAdapter($filesystem);
$client = new Client('YOUR DEV TOKEN', $adapter);
$response = $client->recognize('path/to/image.jpg');

print_r($response);

```

## License

The MIT License (MIT). Please see [License File](https://github.com/bradestey/evernote-ocr/blob/master/LICENSE) for more information.
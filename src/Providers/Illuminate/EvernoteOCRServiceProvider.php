<?php

namespace Estey\EvernoteOCR\Providers\Illuminate;

use Estey\EvernoteOCR\Client;
use Estey\EvernoteOCR\FileAdapters\IlluminateFileAdapter;
use Illuminate\Support\ServiceProvider;

/**
 * Evernote OCR Service Provider
 *
 * This class is a service provider for the Laravel framework.
 */
class EvernoteOCRServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('evernote_ocr', function ($app, $params) {
            return new Client(
                getenv('EVERNOTE_DEV_TOKEN'),
                new IlluminateFileAdapter($params[0], $app['files'])
            );
        });
    }
}

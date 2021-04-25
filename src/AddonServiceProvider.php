<?php

namespace Eleven59\VimeoConnector;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'eleven59';
    protected $packageName = 'vimeo-connector';
    protected $commands = [];
}

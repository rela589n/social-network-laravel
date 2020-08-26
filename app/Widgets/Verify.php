<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\User;

class Verify extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
     public $cacheTime = 60;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $verify = User::where('id', $this->config['id'])
                        ->where('verify', 1)->first();
        
        return view('widgets.verify', [
            'config' => $this->config,
            'verify' => $verify
        ]);
    }
}

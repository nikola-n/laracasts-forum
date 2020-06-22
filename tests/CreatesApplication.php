<?php

namespace Tests;

use App\User;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->be($user);

        return $this;
    }
}

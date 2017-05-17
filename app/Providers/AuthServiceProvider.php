<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use phpCAS;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureCAS();
        $this->registerPolicies();
    }

    /**
     * Configure CAS
     *
     * @return void
     */
    public function configureCAS()
    {
        if(env('CAS_DEBUG', false))
        {
            phpCAS::setDebug();
        }

        phpCAS::setVerbose(env('CAS_VERBOSE', false));

        phpCAS::client(env('CAS_VERSION'), env('CAS_HOST'), (int) env('CAS_PORT'), env('CAS_CONTEXT'));
        $phpCASClient   = new \ReflectionProperty('phpCAS', '_PHPCAS_CLIENT');
        $phpCASClient->setAccessible(true);
        $client         = $phpCASClient->getValue();

        if(!env('CAS_HTTPS', true))
        {
            $url = 'http://' . env('CAS_HOST');

            if(env('CAS_PORT') != '80')
            {
                $url = $url . ':' . env('CAS_PORT');
            }

            $url = $url . env('CAS_CONTEXT') . '/';
            
            $client->setBaseUrl($url);
        }

        if(!env('CAS_VALIDATE', false))
        {
            phpCAS::setNoCasServerValidation();
        }
    }
}

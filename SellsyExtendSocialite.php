<?php

namespace Relaypilot\Sellsy;

use SocialiteProviders\Manager\SocialiteWasCalled;

class SellsyExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('sellsy', Provider::class);
    }
}

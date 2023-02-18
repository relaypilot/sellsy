<?php

namespace Relaypilot\Sellsy;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'SELLSY';

    /**
     * {@inheritdoc} 
     */
    protected $scopes = [
        'comments.read',
        'comments.write',
        'contacts.read',
        'contacts.write',
        'individuals.read',
        'companies.read',
        'companies.write',
        'estimates.read',
        'estimates.write',
        'activities.write',
        'activities.read',
        'listings.read',
        'listings.write',
        'custom-fields.read',
        'custom-fields.write',
        'smart-tags.read',
        'smart-tags.write',
        'custom-activities.read',
        'custom-activities.write',
        'scopes.read',
        'access-tokens.read',
        'access-tokens.write',
        'clients.read',
        'clients.write',
        'accounting-codes.read',
        'taxes.read',
        'taxes.write',
        'ocr.read',
        'individuals.write',
        'accounts.read',
        'accounts.write',
        'opportunities.read',
        'opportunities.write',
        'orders.read',
        'orders.write',
        'tasks.read',
        'tasks.write',
        'staffs.read',
        'staffs.write',
        'search.read',
        'phonecalls.read',
        'phonecalls.write',
        'calendars.read',
        'calendars.write',
        'emails.read',
        'emails.settings',
        'webhooks.read',
        'webhooks.write',
        'payments.read',
        'payments.write',
        'items.read',
        'items.write',
        'invoicing.read',
        'notifications.read',
        'notifications.write',
        'accounting-entry.read',
        'accounting-entry.write',
        'invoices.read',
        'invoices.write',
        'api-v1',
        'credit-notes.read',
        'credit-notes.write',
        'document-layouts.read',
        'rate-categories.read',
        'rate-categories.write',
        'files.write',
        'files.read',
        'adyen.read',
        'adyen.write',
        'subscriptions.write'
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://login.sellsy.com/oauth2/authorization', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://login.sellsy.com/oauth2/access-tokens';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://api.sellsy.com/v2/teams', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['data']['id'],
            'nickname' => $user['data']['first_name'],
            'name'     => $user['data']['first_name'].' '.$user['data']['last_name'],
            'email'    => $user['data']['email'],
            'avatar'   => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}

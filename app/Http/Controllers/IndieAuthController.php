<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndieAuthController extends Controller
{
    /**
     * Protect the various routes from logged in users.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Take a login request and send them to their IndieAuth endpoint.
     *
     * @return \Illuminae\Http\Redirect
     */
    public function login()
    {
        $url = $this->normalizeUrl(request()->input('me'));
        $authEndpoint = \IndieAuth\Client::discoverAuthorizationEndpoint($url);

        if (empty($authEndpoint) === true) {
            return redirect()->route('home')->with(
                'error',
                'Unable to determine authorization endpoint'
            );
        }
        session(['auth-endpoint' => $authEndpoint]);

        $state = bin2hex(random_bytes(16));
        session(['state' => $state]);

        $authUrl = \IndieAuth\Client::buildAuthorizationUrl(
            $authEndpoint,
            $url,
            route('login-callback'), // redirect_uri
            route('home'), //client_id
            $state,
            'create update' // scope
        );

        if (empty($authUrl) === true) {
            return redirect()->route('home')->with(
                'error',
                'Unable to redirect you to your authorization endpoint'
            );
        }

        return redirect($authUrl);
    }

    /**
     * Process the callback request from the authorization endpoint.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function callback()
    {
        if (session('state') != request()->input('state')) {
            return redirect()->route('home')->with(
                'error',
                'The states do not match'
            );
        }

        $verfiedCredentials = \IndieAuth\Client::verifyIndieAuthCode(
            session('auth-endpoint'),
            request()->input('code'),
            request()->input('me'),
            route('login-callback'), // redirect_uri
            route('home') // client_id
        );

        if (array_key_exists('error', $verfiedCredentials)) {
            return redirect()->route('home')->with(
                'error',
                'There was an error verifying the IndieAuth code'
            );
        }

        $user = User::firstOrCreate([
            'url' => $this->normalizeUrl($verifyIndieAuthCode['me']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Normalize a URL.
     *
     * @param  string  $url
     * @return string
     */
    public function normalizeUrl(string $url): string
    {
        $parsed = parse_url($url);
        if (array_key_exists('scheme', $parsed) === false) {
            $parsed['scheme'] = 'http';
        }
        if (array_key_exists('path', $parsed) && $parsed['path'] === '/') {
            unset($parsed['path']);
        }

        $normalized = $parsed['scheme'] . '://' . $parsed['host'];
        if (isset($parsed['path'])) {
            $normalized .= $parsed['path'];
        }

        return $normalized;
    }
}

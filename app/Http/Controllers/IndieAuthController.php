<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
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
     * Show a custom login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
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
        $tokenEndpoint = \IndieAuth\Client::discoverTokenEndpoint($url);
        $micropubEndpoint = \IndieAuth\Client::discoverMicropubEndpoint($url);

        if (empty($authEndpoint) === true) {
            return redirect()->route('home')->withErrors([
                'indieauth' => 'Unable to determine the authorization endpoint',
            ]);
        }
        if (empty($tokenEndpoint) === true) {
            return redirect()->route('home')->withErrors([
                'indieauth' => 'Unable to determine the token endpoint',
            ]);
        }
        if (empty($micropubEndpoint) === true) {
            return redirect()->route('home')->withErrors([
                'indieauth' => 'Unable to determine the micropub endpoint',
            ]);
        }
        session(['auth-endpoint' => $authEndpoint]);
        session(['token-endpoint' => $tokenEndpoint]);
        session(['micropub-endpoint' => $micropubEndpoint]);
        session(['remember' => request()->input('remember')]);

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
            return redirect()->route('home')->with([
                'indieauth' => 'Unable to redirect you to your authorization endpoint',
            ]);
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
            return redirect()->route('home')->withErrors([
                'indieauth' => 'The states do not match',
            ]);
        }

        $user = User::firstOrCreate([
            'me' => $this->normalizeUrl(request()->input('me')),
        ]);

        if ($user->token === null) {
            $accessTokenResponse = \IndieAuth\Client::getAccessToken(
                session('token-endpoint'),
                request()->input('code'),
                request()->input('me'),
                route('login-callback'), // redirect_uri
                route('home') // client_id
            );

            if (array_key_exists('access_token', $accessTokenResponse) !== true) {
                return redirect()->route('home')->withErrors([
                    'indieauth' => 'There was an error verifying the IndieAuth code',
                ]);
            }

            $user->token = $accessTokenResponse['access_token'];
            $user->scope = $accessTokenResponse['scope'];
            $user->micropub_endpoint = session('micropub-endpoint');
            $user->save();
        }

        Auth::login($user, session('remember'));

        return redirect()->route('dashboard');
    }

    /**
     * Logout a user.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
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

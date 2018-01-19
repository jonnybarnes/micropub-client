<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as Guzzle;

class BackendController extends Controller
{
    /**
     * Only allow logged-in users.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Process the request to make a new note.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function note()
    {
        $headers = ['Authorization' => 'Bearer ' . Auth::user()->token];
        if (Auth::user()->method == 'html5') {
            try {
                $response = resolve(Guzzle::client)->request(
                    'POST',
                    Auth::user()->micropub_endpoint,
                    [
                        'headers' => ['Authorization' => 'Bearer ' . Auth::user()->token],
                        'form_params' => [
                            'h' => 'entry',
                            'content' => request()->input('note'),
                        ],
                    ]
                );
            } catch (BadResponseException $exception) {
                return redirect()->route('note')->with(
                    'error',
                    'Error sending response to your micropub endpoint'
                );
            }
        }
        if (Auth::user()->method == 'json') {
            try {
                $response = resolve(Guzzle::client)->request(
                    'POST',
                    Auth::user()->micropub_endpoint,
                    [
                        'headers' => ['Authorization' => 'Bearer ' . Auth::user()->token],
                        'json' => [
                            'type' => ['h-entry'],
                            'properties' => [
                                'content' => [request()->input('note')],
                            ],
                        ],
                    ]
                );
            } catch (BadResponseException $exception) {
                return redirect()->route('note')->with(
                    'error',
                    'Error sending response to your micropub endpoint'
                );
            }
        }

        if ($response->hasHeader('Location')) {
            $redirect = array_get($resposne->getHeader('Location'), 0);
            if (empty($redirect) === true) {
                return redirect()->route('note')->with(
                    'status',
                    'Empty location response from micropub endpoint'
                );
            }

            return redirect($redirect);
        }

        if ($response->getStatusCode() == 201) {
            return redirect()->route('note')->with(
                'status',
                'No location response from micropub endpoint, though status code indicates request was successful'
            );
        }

        return redirect()->route('note')->with(
            'error',
            'There was an error creating the new note'
        );
    }
}

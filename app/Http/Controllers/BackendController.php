<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Auth;

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
        info(request());
        return response()->json([
            'response' => 'Note created',
        ]);
        /*$headers = ['Authorization' => 'Bearer ' . Auth::user()->token];
        if (Auth::user()->method == 'html5') {
            $form_params = [
                'h' => 'entry',
            ];
            if (request()->has('content')) {
                $form_params['content'] = request()->input('content');
            }
            if (request()->has('inReplyTo')) {
                $form_params['in-reply-to'] = request()->input('inReplyTo');
            }
            if (request()->has('syndicate')) {
                foreach (request()->input('syndicate') as $target) {
                    $form_params['mp-syndicate-to[]'][] = $target;
                }
            }
            if (request()->has('media')) {
                foreach (request()->input('media') as $media) {
                    $form_params['media[]'][] = $media;
                }
            }
            if (request()->has('location')) {
                $form_params['location'] = 'geo:' . request()->input('latitude') 
                                            . ',' . request()->input('longitude')
                                          . ';u=' . request()->input('accuracy');
            }
            try {
                $response = resolve(Guzzle::class)->request(
                    'POST',
                    Auth::user()->micropub_endpoint,
                    [
                        'headers' => ['Authorization' => 'Bearer ' . Auth::user()->token],
                        'form_params' => $form_params,
                    ]
                );
            } catch (BadResponseException $exception) {
                return redirect()->route('note')->withErrors([
                    'micropub' => 'Error sending response to your micropub endpoint',
                ]);
            }
        }
        if (Auth::user()->method == 'json') {
            $json = [
                'type' => ['h-entry'],
                'properties' => [],
            ];
            if (request()->has('inReplyTo')) {
                $json['properties']['in-reply-to'] = request()->input('inReplyTo');
            }
            if (request()->has('syndicate')) {
                foreach (request()->input('syndicate') as $target) {
                    $json['properties']['mp-syndicate-to'][] = $target;
                }
            }
            if (request()->has('media')) {
                foreach (request()->input('media') as $media) {
                    $json['properties']['photo'][] = $media;
                }
            }
            if (request()->has('location')) {
                $json['properties']['location'] = 'geo:' . request()->input('latitude') 
                                            . ',' . request()->input('longitude')
                                          . ';u=' . request()->input('accuracy');
            }
            try {
                $response = resolve(Guzzle::class)->request(
                    'POST',
                    Auth::user()->micropub_endpoint,
                    [
                        'headers' => ['Authorization' => 'Bearer ' . Auth::user()->token],
                        'json' => $json,
                    ]
                );
            } catch (BadResponseException $exception) {
                return redirect()->route('note')->withErrors([
                    'micropub' => 'Error sending response to your micropub endpoint',
                ]);
            }
        }

        if ($response->hasHeader('Location')) {
            $redirect = array_get($response->getHeader('Location'), 0);
            if (empty($redirect) === true) {
                return redirect()->route('note')->with(
                    'status',
                    'Empty location response from micropub endpoint'
                );
            }

            return redirect($redirect);
        }

        if ($response->getStatusCode() == 201) {
            return redirect()->route('note')->withErrors(
                'status',
                'No location response from micropub endpoint, though status code indicates request was successful'
            );
        }

        return redirect()->route('note')->withErrors([
            'micropub' => 'There was an error creating the new note'
        ]);*/
    }
}

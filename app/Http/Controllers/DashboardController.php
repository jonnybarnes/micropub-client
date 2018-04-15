<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\BadResponseException;

class DashboardController extends Controller
{
    /**
     * Make sure requests are from auth’d users.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the main dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('settings');
    }

    /**
     * Query the micropub endpoint for config settings.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryEndpoint()
    {
        $user = Auth::user();
        if (empty($user->micropub_endpoint) === true) {
            return response()->json([
                'error' => 'No micropub endpoint defined',
            ], 400);
        }

        try {
            $response = resolve(Guzzle::class)->request(
                'GET',
                $user->micropub_endpoint,
                [
                    'headers' => ['Authorization' => 'Bearer ' . $user->token],
                    'query' => ['q' => 'config'],
                ]
            );
        } catch (BadResponseException $exception) {
            return response()->json([
                'error' => 'There was an error querying the micorpub endpoint'
            ], 400);
        }

        $data = json_decode((string) $response->getBody(), true);
        if (array_key_exists('media-endpoint', $data)) {
            $user->media_endpoint = $data['media-endpoint'];
        }
        if (array_key_exists('syndicate-to', $data)) {
            $user->syndication_targets = json_encode($data['syndicate-to']);
        }
        $user->save();

        return response()->json([
            'media_endpoint' => $user->media_endpoint,
            'syndication_targets' => $user->syndication_targets,
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            "auth" => function () {
                if (!auth()->guest()) {
                    $auth = auth()->user();
                    $data = $auth->only('name', 'id', 'slug');
                    $data['photo-avatar'] = $auth->profile_photo_path ? url('storage/' . $auth->profile_photo_path) :  '../../images/profile/post-media/2.jpg';
                    return  $data;
                }
                return null;
            },
            "menus" => function () {
                $menus = require(app_path('\Http\menus.php'));
                return [
                    'side_bar' => collect($menus['side_bar'])->filter(),
                    'actions' => $menus['actions'],
                ];
            },
            'errorBags' => function () {
                return collect(optional(Session::get('errors'))->getBags() ?: [])->map(function ($bag) {
                    return (object) collect($bag->messages())->map(function ($errors) {
                        return $errors[0];
                    })->toArray();
                })->pipe(function ($bags) {
                    return $bags->has('default') ? $bags->get('default') : $bags->toArray();
                });
            },
            'message' => function () {
                return Session::get('message') ?: null;
            },
            'currentRoute' => $request->getPathInfo(),
            'url' => url('/'),
            "routes" => collect(app('router')->getRoutes()->getRoutesByName())->map(function ($item) {
                return $item->uri;
            })->toArray(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as ResourcesPost;
use App\Http\Resources\User as ResourcesUser;
use Illuminate\Auth\Access\Gate;

class ProfileController extends Controller
{
    protected $user;

    protected $only;

    public function __construct()
    {
        if (request()->header('x-inertia-partial-data')) {
            $this->only = explode(',', request()->header('x-inertia-partial-data'));
        }
    }
    // ////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @return back to the profile page
     * @param   Illuminate\Http\Request
     */
    public function follow(Request $request)
    {
        $user = User::find($request->id);
        auth()->user()->follow()->toggle($user);
        return back(303);
    }
    // /////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return profile page with user data
     * @param   Illuminate\Http\Request
     * @param   App\Models\User;
     */
    public function index(User $user, Request $request)
    {
        $this->user = $user;
        if (!is_array($request) && $request->wantsJson()) {
            // this responce for lod mor posts with scroll by axios
            return $this->getPosts();
        }
        return inertia('profile/index', $this->get_shared_data());
    }

    /**
     * @return array with the user data
     */
    public function get_shared_data()
    {
        // this data  loded when the profile page loade in first time
        $data = [
            'authFollowCurrentUser' => function () {
                if ($this->user->id == auth()->user()->id) return;
                return  $this->user->followers->find(auth()->user()) || false;
            },
            'user' => function () {
                return collect(new ResourcesUser($this->user));
            },
            'followers' => function () {
                $user = $this->user->withCount('follow', 'followers')->with('follow', 'followers')->where('id', $this->user->id)->first();
                // this collection return array with all ids of the auth->user
                $authFollowers = auth()->user()->follow->map(function ($item) {
                    return $item['id'];
                })->toArray();
                return [
                    'follow_count' => $user->follow_count,
                    'followers_count' => $user->followers_count,
                    'follow' => $this->get_followers($user->follow->take(6), $authFollowers),
                    'followers' => $this->get_followers($user->followers->take(6), $authFollowers),
                ];
            },
            'profileImages' => function () {
                $userImages =  $this->user->images()->firstWhere('role', 'cover');
                return [
                    'cover' => $userImages ? url("storage/" . $userImages->only('url')['url']) : null,
                    'avatar' =>  $this->user->profile_photo_path ? url("storage/" .  $this->user->profile_photo_path) : null,
                ];
            },
            'posts' => function () {
                return  $this->getPosts();
            },
            'allImages' => function () {
                $all_images = $this->user->images()->limit(9)->get()->map(function ($data) {
                    return [
                        'url' => url("storage/" . $data['url']),
                        'id' => $data['id'],
                        'user_id' => $data['imageable_id'],
                        'role' => $data['role'],
                        'meta' => 'not seported',
                    ];
                });
                return !$all_images->isEmpty() ? $all_images->toArray() : null;
            }
        ];
        /**
         * @return this resource if the current user  like ou comment any post
         * @param the only array comes from the inertia request
         */
        if ($this->only && in_array('comment', $this->only)) {
            $data['comment'] = function () {
                return new ResourcesPost(
                    Post::with(
                        [
                            'comments' => function ($query) {
                                $query->orderBy('id', 'desc');
                            },
                            'comments.user'
                        ]
                    )
                        ->withCount('comments')
                        ->find($this->only[1])
                );
            };
        }
        /**
         * @return this resource if the current user  like ou comment any post
         * @param the only array comes from the inertia request
         */
        if ($this->only && in_array('like', $this->only)) {
            $data['like'] = function () {
                return new ResourcesPost(
                    Post::with(['likes' => function ($query) {
                        $query->orderBy('id', 'asc');
                    }])
                        ->withCount('likes')
                        ->find($this->only[1])
                );
            };
        }
        /**
         * @return this resource if the current user  create new post
         * @param the only array comes from the inertia request
         */
        if ($this->only && in_array('post', $this->only)) {
            $data['post'] = function () {
                return new ResourcesPost(
                    $this->user->posts()
                        ->with($this->get_post_relations())
                        ->withCount('comments', 'likes', 'images')
                        ->orderBy('id', 'desc')
                        ->take(1)->first()
                );
            };
        }
        return $data;
    }
    public function get_followers($collection, $authFollowers)
    {
        $collection = $collection->map(function ($item) use ($authFollowers) {
            $item = $item->toArray();
            // check if the auth can follow this user
            $item['canFollow'] = $item['id'] !== auth()->id();
            // check if the auth follow this user
            $item['authFollowThisUser'] = in_array($item['id'], $authFollowers);

            $item['followUrl'] = route('profile.follow', $item['id']);
            $item['profileUrl'] = route('profile', $item['slug']);
            $item['avatar'] = url('storage/' . $item['profile_photo_path']);
            return collect($item)->only('id', 'avatar', 'name', 'profileUrl', 'canFollow', 'followUrl', 'authFollowThisUser');
        });
        return $collection;
    }
    /**
     * @return user posts
     */
    public function getPosts()
    {
        return  new PostCollection(
            $this->user->posts()
                ->with($this->get_post_relations())
                ->withCount('comments', 'likes', 'images')
                ->orderBy('id', 'desc')
                ->paginate(2)
        );
    }
    /**
     * @return relations as aggregate from the user
     */
    public function get_post_relations()
    {
        return [
            'likes' => function ($q) {
                $q->orderBy('id', 'asc');
            },
            'comments' => function ($q) {
                $q->orderBy('id', 'desc');
            },
            'comments.user',
            'images',
            'user.followers'
        ];
    }
    // ////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return edit page
     */
    public function edit()
    {
        $user = auth()->user();
        return inertia(
            'profile/edit',
            [
                'user' => function () use ($user) {
                    $data = collect($user)->mapWithKeys(function ($val, $key) {
                        if ($val == null) {
                            return [];
                        }
                        if ($key == 'date') {
                            return [$key => Carbon::parse($val)->format('Y-m-d')];
                        }
                        return [$key => $val];
                    });
                    return $data;
                },
                'images' => function () use ($user) {
                    return $user->images;
                },
            ]
        );
    }

    /**
     * @param  Illuminate\Http\Request
     * @param  Illuminate\Support\Facades\Auth
     * @return back to the edit page
     */
    public function store(Request $request, Auth $auth)
    {
        $authUser = $auth::user();
        //validate the data 
        $data = $request->validate([
            'name' => 'min:5|unique:users,name,' . $authUser->id,
            'email' => 'email|unique:users,email,' . $authUser->id,
            'date' => 'date',
            'mobile' => '',
            'postcode' => '',
            'languages' => '',
            'gender' => '',
            'contactOptions' => '',
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'state' => '',
            'country' => '',
            'website' => '',
        ]);

        //insert a custom Slug to the user information
        $data['slug'] = Str::slug($data['name'] . '-' . $authUser->id);

        //call Update Method from the Model
        $authUser->update($data);

        //back to the current page
        return $request->wantsJson()
            ? new Response('', 200)
            : back()->with('status', 'profile information updated');
    }
    // ///////////////////////////////////////////////////////////////////////////////////////////////

}

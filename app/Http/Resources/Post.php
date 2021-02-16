<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_at = str_split((new Carbon($this->created_at))->longAbsoluteDiffForHumans())[2];
        return [
            // actions
            'edit' => auth()->user() && auth()->user()->can('update', $this->resource) ? url(route('post.edit', $this->id)) : false,
            'update' =>  auth()->user() && auth()->user()->can('update', $this->resource) ?  url(route('post.update', $this->id)) : false,
            'delete' =>  auth()->user() && auth()->user()->can('delete', $this->resource) ?  url(route('post.destroy', $this->id)) : false,
            'show' => url(route('post.show', $this->id)),
            // data
            'user' => $this->get_user(),
            'disable_comments' => $this->disable_comments,
            'content' => \json_decode($this->content),
            'auth_like_post' => $this->authLikePost(),
            'comments_count' => $this->comments_count,
            'images_count' => $this->images_count,
            'likes_count' => $this->likes_count,
            'title' => Str::title($this->title),
            'comments' => $this->get_comment(),
            'images' => $this->get_images(),
            'likes' => $this->get_likes(),
            'visibility' => $this->visibility,
            'publish' => $this->publish,
            'id' => $this->id,
            'created_at' => Carbon::make($this->created_at)->diffForHumans(),
            'is_new_post' => $created_at == 'd' || $created_at == 'h' ? true : false
        ];
    }

    public function get_user()
    {
        $user = $this->whenLoaded('user');
        return new UserInfo($user);
    }
    public function get_comment()
    {
        if (!key_exists('comments', $this->getRelations())) return;
        return $this->whenLoaded('comments')->take(3)->map(function ($item) {
            $comment = $item;
            $avatar = $comment['user']['profile_photo_path'];
            $comment['profile_url'] = route('profile', $comment['user']->slug);
            $comment['profile_avatar'] = $avatar ?  url('storage/' . $avatar) : null;
            $comment['profile_name'] = $comment['user']->name;
            $comment = $item->only('id', 'content', 'profile_name', 'profile_url', 'profile_avatar', 'created_at');
            return $comment;
        })->toArray();
    }
    public function get_likes()
    {
        if (!key_exists('likes', $this->getRelations())) return;
        return $this->whenLoaded('likes')->take(5)->map(function ($item) {
            $like = $item;
            $avatar = $like['profile_photo_path'];
            $like['profile_url'] = route('profile', $like->slug);
            $like['profile_avatar'] = $avatar ? url('storage/' . $avatar) : null;
            $like['profile_name'] = $like->name;
            $like = $item->only('id', 'profile_name', 'profile_url', 'profile_avatar');
            return $like;
        })->toArray();
    }
    public function get_images()
    {
        if (!key_exists('images', $this->getRelations())) return;
        return $this->images ? $this->whenLoaded('images')->take(3)->map(function ($item) {
            $item['url'] =  url($item['url']);
            return $item->only('id', 'url');
        }) : null;
    }

    public function authLikePost()
    {
        if (!key_exists('likes', $this->getRelations())) return;
        $is_liked = $this->whenLoaded('likes')->filter(function ($item) {
            return $item['id'] == auth()->user()->id;
        });
        return !$is_liked->toArray() == null;
    }
}

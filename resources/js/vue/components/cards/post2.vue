<template>
	<card class="w-full relative">
		<button
			v-if="dataPost.edit"
			type="button"
			class="absolute top-5 right-6 bg-gray-100 border-2 border-gray-400 border-solid shadow active:shadow-inner focus:outline-none rounded-full"
			@click="showactionsMenu = !showactionsMenu"
		>
			<i class="feather icon-more-horizontal px-1 -my-1"></i>
		</button>
		<transition
			enter-active-class="transition ease-out duration-200"
			enter-class="transform opacity-0 scale-95"
			enter-to-class="transform opacity-100 scale-100"
			leave-active-class="transition ease-in duration-200"
			leave-class="transform opacity-100 scale-100"
			leave-to-class="transform opacity-0 scale-95"
		>
			<div
				v-if="dataPost.edit"
				v-show="showactionsMenu"
				@mouseleave="showactionsMenu = false"
				class="absolute top-10 right-5 w-24 rounded-md shadow z-10"
			>
				<div class="py-1 rounded-md bg-white shadow-xs">
					<inertia-link
						:href="dataPost.edit"
						class="px-4 py-2 text-gray-700 hover:bg-gray-200 font-semibold text-md flex justify-between items-center"
					>
						<span>Edit</span>
						<i class="feather icon-edit"></i>
					</inertia-link>
					<inertia-link
						:href="dataPost.delete"
						@success="deleted"
						method="DELETE"
						preserve-scroll
						preserve-state
						:only="['auth']"
						class="px-4 py-2 text-gray-700 hover:bg-gray-200 font-semibold text-md flex justify-between items-center"
						><span>Trash</span>
						<i class="feather icon-trash-2 text-red-600"></i>
					</inertia-link>
				</div>
			</div>
		</transition>
		<div v-if="dataPost.images_count" slot="image">
			<post-images :images="dataPost.images" :count="dataPost.images_count" />
		</div>
		<h1 class="text-3xl" slot="title">
			<inertia-link :href="dataPost.show" v-text="dataPost.title" />
		</h1>
		<div class="divide-solid divide-black border"></div>
		<div class="flex items-center justify-between">
			<div class="flex items-center">
				<div @click="likePost" class="cursor-pointer">
					<i
						class="feather text-2xl mr-3"
						:class="{
							'text-red-600 icon-heart-on': dataPost.auth_like_post,
							'icon-heart': !dataPost.auth_like_post,
						}"
					></i>
				</div>
				<image-users-list :list="dataPost.likes" :more="dataPost.likes_count" />
			</div>
			<div class="flex items-center mr-2 text-gray-600">
				<i class="feather icon-message-square text-2xl mr-1"></i>
				<span class="pb-2">
					{{ dataPost.comments_count }}
				</span>
			</div>
		</div>
		<div class="space-y-5 mx-2">
			<comment v-for="comment in dataPost.comments" :key="comment.id" :comment="comment" />
		</div>
		<add-comments :post="dataPost.id" @comment="commented" />
	</card>
</template>

<script>
	import imageUsersList from '@vue/components/image-users-list';
	import postImages from '@vue/components/postImages';
	import comment from '@vue/components/comment';
	import addComments from '@vue/components/addComments';
	import { Inertia } from '@inertiajs/inertia';
	export default {
		props: ['post', 'index'],
		components: { imageUsersList, comment, addComments, postImages },
		data() {
			return {
				post_data: this.post,
				showactionsMenu: false,
			};
		},
		computed: {
			dataPost() {
				return this.post_data;
			},
		},
		methods: {
			deleted() {
				this.$store.dispatch('deletePost', {
					index: this.index,
				});
			},
			likePost() {
				Inertia.put(this.$routes('post.like', [this.post.id]), null, {
					preserveScroll: true,
					preserveState: true,
					only: ['like', this.post.id],
					onSuccess: page => {
						let likes = page.props.like.data.likes;
						let likes_count = page.props.like.data.likes_count;
						let auth_like_post = page.props.like.data.auth_like_post;
						this.post_data = {
							...this.post_data,
							auth_like_post,
							likes,
							likes_count,
						};
					},
				});
			},
			commented(page) {
				let comments = page.props.comment.data.comments;
				let count = page.props.comment.data.comments_count;
				this.post_data = {
					...this.post_data,
					comments,
					comments_count: count,
				};
			},
		},
	};
</script>

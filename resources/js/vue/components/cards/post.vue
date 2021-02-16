<template>
	<card class="w-full relative">
		<template #image v-if="post_data.images.length">
			<post-images :images="post_data.images" :count="post_data.images_count" />
		</template>
		<template #title>
			<h2
				:class="[
					{ 'mt-15': !post_data.images.length },
					'pl-4 text-3xl truncate max-w-11/12',
				]"
			>
				<a :href="post_data.show" v-text="post_data.title"></a>
			</h2>
		</template>
		<template>
			<div
				class="absolute bg-gray-900 bg-opacity-50 border flex items-center justify-between left-4 pl-2 pr-4 py-1 right-4 rounded-full shadow text-gray-100 top-2"
			>
				<div class="flex justify-between items-center">
					<!-- user -->
					<div class="w-8 h-8">
						<img
							:src="user.avatar"
							class="w-full h-full object-cover rounded-full"
							alt="avatar"
						/>
					</div>
					<div class="text-xs flex flex-col ml-2">
						<inertia-link :href="user.url">
							<span class="font-semibold" v-text="user.name"></span>
						</inertia-link>
						<span>{{ post_data.created_at | date }}</span>
					</div>
				</div>
				<div class="space-x-2 space-x-reverse text-sm">
					<div class="inline-flex items-center mr-2">
						<i
							@click="likePost"
							class="feather icon-heart-on text-sm mr-1 cursor-pointer"
							:class="{
								'text-red-400': dataPost.auth_like_post,
								'text-gray-100 ': !dataPost.auth_like_post,
							}"
						></i>
						<span>{{ 1000 | k_formatter }}</span>
					</div>
					<div class="inline-flex items-center">
						<i class="feather icon-message-square mr-1"></i>
						<span>{{ 1200 | k_formatter }}</span>
					</div>
					<div class="inline-flex items-center">
						<i class="feather icon-share-2"></i>
					</div>
					<div class="inline-flex items-center">
						<i class="feather icon-eye mr-1"></i>
						<span> {{ 1111000 | k_formatter }}</span>
					</div>
					<div
						class="inline-flex items-center px-2 py-1 rounded-full"
						v-if="post_data.edit"
					>
						<i
							class="feather icon-more-horizontal cursor-pointer"
							@click="showactionsMenu = true"
						></i>
						<transition
							enter-active-class="transition ease-out duration-100"
							enter-class="transform opacity-0 scale-95"
							enter-to-class="transform opacity-100 scale-100"
							leave-active-class="transition ease-in duration-75"
							leave-class="transform opacity-100 scale-100"
							leave-to-class="transform opacity-0 scale-95"
						>
							<div
								v-show="showactionsMenu"
								@mouseleave="showactionsMenu = false"
								class="absolute top-11 right-3 w-24 rounded-md shadow z-10"
							>
								<div class="py-1 rounded-md bg-white shadow-xs">
									<inertia-link
										:href="post_data.edit"
										class="px-4 py-2 text-gray-700 hover:bg-gray-200 font-semibold text-md flex justify-between items-center"
									>
										<span>Edit</span>
										<i class="feather icon-edit"></i>
									</inertia-link>
									<inertia-link
										:href="post_data.delete"
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
					</div>
				</div>
			</div>
			<div class="space-y-4">
				<p
					class="px-6 text-sm font-normal text-gray-900 post-block"
					v-if="content"
					v-html="content"
				></p>
				<div class="pt-2 px-6">
					<comment
						v-for="(comment, index) in post_data.comments"
						:comment="comment"
						:key="index"
					/>
				</div>
				<add-comments :post="dataPost.id" @comment="commented" />
			</div>
		</template>
	</card>
</template>

<script>
	import postImages from '@vue/components/postImages';
	import comment from '@vue/components/comment';
	import addComments from '@vue/components/addComments';
	import { Inertia } from '@inertiajs/inertia';
	export default {
		props: ['post', 'index'],
		components: {
			comment,
			addComments,
			postImages,
		},
		data() {
			return {
				post_data: this.post,
				user: this.post.user,
				showactionsMenu: false,
			};
		},
		computed: {
			dataPost() {
				return this.post_data;
			},
			content() {
				if (this.post_data.content) {
					let count = 0;
					let content = this.post_data.content.blocks.filter(block => {
						if (count == 0 && block.type == 'paragraph') {
							count++;
							return block;
						}
						return false;
					});
					if (content.length) {
						return content[0].data.text;
					}
				}
			},
		},
		methods: {
			updateData(page) {},
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

<style scoped>
.post-block a {
	color: blue;
	text-decoration: blue underline;
}
</style>

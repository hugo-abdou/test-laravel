<template>
	<div>
		<!-- star * Profile header * avatar and cover imgs  * foolow and edit btn-->
		<profile-head :profileImages="profileImages" :user="user" :follow="authFollowCurrentUser" />
		<!-- end * Profile header * avatar and cover imgs * foolow and edit btn -->

		<!-- star * profile body *  -->
		<div class="w-full mt-8">
			<div class="flex flex-wrap">
				<div class="flex flex-col items-center w-4/12 mx-auto space-y-8">
					<about :user="user" />
					<photos :images="allImages" v-if="allImages" />
					<followers
						v-if="followers.follow_count"
						:followers="followers.follow"
						:count="followers.follow_count"
						title="Follow"
					/>
					<followers
						v-if="followers.followers_count"
						:followers="followers.followers"
						:count="followers.followers_count"
						title="Followers"
					/>
					<polls />
				</div>
				<div class="flex flex-col items-center w-7/12 mx-auto space-y-4">
					<post
						v-for="(post, index) in getPosts"
						:index="index"
						:key="post.id"
						:post="post"
					/>
					<div class="text-2xl text-gray-600 animate-pulse  p-4" v-show="loadingPosts">
						<i class="feather icon-refresh-cw inline-block animate-spin"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Profile from '@store/profile';
	import { createNamespacedHelpers } from 'vuex';
	const { mapGetters, mapState } = createNamespacedHelpers('profile');

	import profileHead from '@vue/components/cards/profile-head';
	import about from '@vue/components/cards/about';
	import photos from '@vue/components/cards/photos';
	import post from '@vue/components/cards/post';
	import followers from '@vue/components/cards/followers';
	import polls from '@vue/components/cards/polls';

	export default {
		props: ['user', 'profileImages', 'posts', 'authFollowCurrentUser', 'allImages', 'followers'],
		components: { profileHead, about, photos, post, followers, polls },
		beforeCreate() {
			let moduleName = 'profile';
			if (!this.$store.state[moduleName]) {
				this.$store.registerModule(moduleName, Profile);
			}
			this.$store.state.profile.posts = [];
			this.$store.commit('profile/setPosts', this.$page.props.posts);
		},
		mounted() {
			window.addEventListener('scroll', this.loadeMorePosts);
		},
		computed: {
			...mapState(['loadingPosts']),
			...mapGetters(['getPosts']),
		},
		methods: {
			loadeMorePosts() {
				this.$store.dispatch('profile/loadeMorePosts');
			},
		},
		beforeDestroy() {
			window.removeEventListener('scroll', this.loadeMorePosts);
		},
	};
</script>

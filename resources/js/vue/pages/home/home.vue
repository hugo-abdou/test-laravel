<template>
	<div
		class="grid grid-cols-1 grid-cols-auto-fill grid-rows-auto-fill gap-x-3 gap-y-5 grid-flow-row-dense"
	>
		<template v-for="post in posts">
			<component :is="postType(post)" :post="post" :key="post.id" />
		</template>
	</div>
</template>
<script>
	export default {
		components: {
			post: require("./post.vue").default,
			ImgPost: require("./img-post.vue").default,
			TextPost: require("./text-post.vue").default,
		},
		computed: {
			posts() {
				return this.$page.props.posts.data;
			},
		},
		methods: {
			postType(post) {
				switch (post.images_count) {
					case 0:
						return "text-post";
						break;
					case 1:
						return "post";
						break;

					default:
						return "img-post";
						break;
				}
			},
		},
	};
</script>

<style scoped>
@media (min-width: 768px) {
	.grid-rows-auto-fill {
		grid-template-rows: repeat(auto-fit, 1fr);
	}
	.grid-cols-auto-fill {
		grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
	}
}
</style>
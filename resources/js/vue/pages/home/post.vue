<template>
	<div class="min-w-72 w-full">
		<div class="relative pb-2/4">
			<img
				:src="post.images[0].url"
				class="absolute top-0 h-full w-full object-cover rounded-md shadow-md"
			/>
			<span
				v-if="post.is_new_post"
				class="absolute top-2 left-2 text-xs bg-blue-200 px-2 rounded-full text-blue-600 font-semibold shadow-md"
				>NUW</span
			>
		</div>
		<div class="relative px-2 -mt-8">
			<div
				class="relative min-h-36 bg-gray-50 dark:bg-gray-800 shadow-lg rounded-md px-4 py-2 overflow-hidden duration-1000"
			>
				<h2 class="text-xl font-bold text-gray-500 dark:text-gray-300 duration-1000">
					{{ post.title | truncate(49) }}
				</h2>

				<user-info :post="post" />
			</div>
		</div>
	</div>
</template>

<script>
	import star from "@vue/components/star";
	import UserInfo from "./user-info.vue";
	export default {
		components: { star, UserInfo },

		props: {
			post: Object,
		},
	};
</script>Star
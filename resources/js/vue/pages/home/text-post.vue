<template>
	<div
		class="relative bg-gray-50 dark:bg-gray-800 duration-1000 min-w-72 w-full shadow-md rounded-md"
	>
		<span
			v-if="post.is_new_post"
			class="absolute top-2 left-2 text-xs bg-blue-200 px-2 rounded-full text-blue-600 font-semibold shadow-md"
		>
			NUW
		</span>
		<div class="w-full px-5 pb-4 text-gray-500 dark:text-gray-300 duration-1000">
			<div class="flex items-center justify-between text-xs mt-10 mb-4">
				<div class="flex items-center">
					<div class="relative h-8 w-8">
						<img
							:src="post.user.avatar"
							class="absolute inset-0 h-full w-full object-cover rounded-full shadow-md border"
						/>
					</div>
					<div class="ml-2 font-semibold">
						<span class="block text-sm leading-5">{{ post.user.name }}</span>

						<span class="text-xs">{{ post.created_at }}</span>
					</div>
				</div>
				<div>
					<span class="flex">
						<star v-for="i in 5" :key="i" class="w-3 text-blue-400" />
					</span>
					<span class="mt-2 inline-block">3K reviews</span>
				</div>
			</div>

			<h2 class="text-xl font-bold">
				{{ post.title | truncate(30) }}
			</h2>
			<div class="mt-2 text-sm">
				<p>
					{{ paragraph | truncate(250) }}
				</p>
			</div>
		</div>
	</div>
</template>

<script>
	import star from "@vue/components/star";
	export default {
		components: { star },
		props: {
			post: Object,
		},
		computed: {
			paragraph() {
				return this.post.content?.blocks.filter((block) => {
					return block.type == "paragraph";
				})[0]?.data.text;
			},
		},
	};
</script>
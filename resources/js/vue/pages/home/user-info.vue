<template>
	<div class="inset-x-4 flex items-center justify-between text-xs text-gray-400 my-4">
		<div class="flex items-center">
			<div class="relative h-8 w-8">
				<img
					:src="post.user.avatar"
					class="absolute inset-0 h-full w-full object-cover rounded-full shadow-md border"
				/>
			</div>
			<div class="ml-2 font-semibold text-gray-500">
				<span class="block text-sm leading-5">{{ post.user.name }}</span>

				<span class="text-xs text-gray-400">{{ post.created_at }}</span>
			</div>
		</div>
		<div>
			<span class="flex">
				<star v-for="i in 5" :key="i" class="w-3 text-blue-400" />
			</span>
			<span class="mt-2 inline-block">3K reviews</span>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			post: Object,
		},
	};
</script>
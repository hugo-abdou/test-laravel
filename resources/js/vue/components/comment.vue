<template>
	<div class="w-full">
		<div class="flex items-center justify-between">
			<div class="flex items-center">
				<inertia-link :href="comment.profile_url">
					<img class="w-6 h-6 rounded-full shadow" :src="comment.profile_avatar" />
				</inertia-link>
				<div>
					<inertia-link
						:href="comment.profile_url"
						class="ml-1.5 text-gray-700 font-semibold inline"
					>
						{{ comment.profile_name }}
					</inertia-link>
					<span class="text-gray-600 text-xs inline whitespace-normal">{{
						comment.created_at | date
					}}</span>
				</div>
			</div>
		</div>
		<p class="ml-10 text-sm text-gray-600 leading-6 font-normal">
			{{ comment.content }}
		</p>
	</div>
</template>

<script>
	export default {
		props: ['comment'],
	};
</script>

<template>
	<card class="w-full">
		<template slot="title">
			<span>{{ title }}
				<span class="text-sm text-gray-600">({{ count }})</span>
			</span>
		</template>
		<template>
			<ul>
				<model-info
					v-for="follower in followers"
					:key="follower.id"
					:follower="follower"
				/>
			</ul>
			<btn class="w-full px-4 py-2 text-center">
				<span>Load More</span>
				<i class="feather icon-plus"></i>
			</btn>
		</template>
	</card>
</template>

<script>
	import modelInfo from '@vue/components/model-info.vue';
	export default {
		props: ['followers', 'count', 'title'],
		components: {
			modelInfo,
		},
	};
</script>

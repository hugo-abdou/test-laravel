<template>
	<div class="flex -space-x-1 items-center">
		<inertia-link
			class="hover:z-10 transform hover:-translate-y-1 hover:scale-125 duration-100 h-6 w-6"
			:href="item.profile_url"
			v-for="item in Flist"
			:key="item.id"
		>
			<img
				class="h-full w-full object-cover shadow rounded-full bg-white border"
				:src="item.profile_avatar"
			/>
		</inertia-link>

		<span v-if="more > 5" class="pl-2 text-white leading-4"
			>+{{ more - Flist.length }} more</span
		>
	</div>
</template>

<script>
	export default {
		props: ['list', 'more'],
		computed: {
			Flist() {
				if (this.list) {
					return this.list.filter(item => {
						return item.profile_avatar;
					});
				}
			},
		},
	};
</script>

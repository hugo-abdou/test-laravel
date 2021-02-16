<template>
	<card class="w-full">
		<template slot="title">
			<span>Polls</span>
		</template>
		<template>
			<span>Who is the best actor in Marvel Cinematic Universe?</span>
			<ul>
				<poll />
				<poll />
				<poll />
				<poll />
			</ul>
		</template>
	</card>
</template>

<script>
	import poll from '@vue/components/poll.vue';
	export default {
		components: {
			poll,
		},
	};
</script>

<template>
	<inertia-link :href="link" class="flex px-2 py-1 hover:bg-gray-300 dark:hover:bg-gray-600">
		<i :class="['ml-1 leading-6', icon]" v-if="!$props.img"> </i>
		<img :src="img" class="h-7 w-7 rounded-full border" v-if="$props.img" />
		<span
			class="ml-6 cursor-pointer inline-block transform hover:translate-x-2 duration-300 w-full"
			>{{ name }}</span
		>
	</inertia-link>
</template>

<script>
	export default {
		props: {
			name: String,
			link: { type: String, default: "#" },
			icon: { type: String, default: "feather icon-circle" },
			img: String,
		},
	};
</script>
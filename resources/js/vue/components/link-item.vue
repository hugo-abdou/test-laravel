<template>
	<inertia-link v-if="!tag" :href="href" :class="linkClass">{{ name }} </inertia-link>
	<a v-else :href="href" :class="linkClass">{{ name }} </a>
</template>

<script>
	export default {
		props: ["href", "name", "tag" || null],
		data() {
			return {
				linkClass: [
					"px-3 py-2 rounded text-sm font-medium focus:outline-none hover:bg-gray-300 text-gray-800",
					"dark:text-gray-200 dark:hover:bg-gray-600 duration-1000",
				],
				currentRoute: this.$page.currentRoute,
			};
		},
		created() {
			this.$page.currentRoute == this.href
				? this.linkClass.push("bg-gray-600 dark:bg-gray-300")
				: "";
		},
	};
</script>

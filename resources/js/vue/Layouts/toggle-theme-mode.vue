<template>
	<div
		class="text-gray-700 bg-gray-400 dark:text-gray-100 text-lg mr-4 p-0.5 rounded-full cursor-pointer duration-1000"
		@click="toggleThemeMode"
	>
		<svg viewBox="0 0 24 24" class="w-4 h-4 fill-current">
			<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
		</svg>
	</div>
</template>

<script>
	export default {
		methods: {
			toggleThemeMode() {
				document.body.classList.toggle("dark");
			},
		},
	};
</script>
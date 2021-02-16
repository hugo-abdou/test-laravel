<template>
	<div class="bg-white rounded-lg shadow overflow-hidden">
		<div v-if="$slots.image" class="w-full overflow-hidden">
			<slot name="image" />
		</div>
		<div v-if="$slots.title" class="text-xl font-semibold m-2">
			<slot name="title" />
		</div>
		<div class="font-medium m-2 overflow-hidden">
			<slot />
		</div>
	</div>
</template>

<script>
	export default {
		name: 'card',
	};
</script>

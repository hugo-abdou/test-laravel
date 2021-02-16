<template>
	<div
		v-if="show"
		class="transform min-w-48 rounded shadow relative"
		:class="{ 'bg-red-200': type == 'error', 'bg-green-200': type == 'success' }"
	>
		<i
			class="feather icon-x-circle absolute top-1 right-1"
			:class="{ ' text-red-600': type == 'error', 'text-green-600': type == 'success' }"
			@click="show = false"
		></i>
		<span
			class="text-center block p-2 pr-6"
			:class="{ ' text-red-600': type == 'error', 'text-green-600': type == 'success' }"
		>
			{{ message }}
		</span>
	</div>
</template>

<script>
	export default {
		props: ['message', 'id', 'type'],
		data() {
			return {
				show: false,
			};
		},
		mounted() {
			this.show = true;
			this['tost_' + this.id] = setInterval(() => {
				this.show = false;
				clearInterval(this['tost_' + this.id]);
			}, 5000);
		},
	};
</script>
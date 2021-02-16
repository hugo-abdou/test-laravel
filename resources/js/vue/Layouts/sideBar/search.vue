<template>
	<div
		:class="[
			'form-input flex items-center justify-between border mx-2 rounded-full  duration-1000',
			'focus-within:shadow-outline-blue bg-gray-100 dark:bg-gray-700 dark:border-gray-800',
		]"
	>
		<input
			type="text"
			class="focus:outline-none bg-white bg-opacity-0 w-full"
			v-model="searech"
			placeholder="Search"
			@keyup="getNewData"
		/>

		<i class="feather icon-search cursor-pointer" @click="getNewData"></i>
	</div>
</template>

<script>
	import _ from "lodash";
	import { Inertia } from "@inertiajs/inertia";
	export default {
		data: () => ({ searech: "" }),
		methods: {
			getNewData: debounce(function () {
				Inertia.get(
					this.$routes("home"),
					{ S: this.searech },
					{
						preserveState: true,
					}
				);
			}, 500),
		},
	};
</script>
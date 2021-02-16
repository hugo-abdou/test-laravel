<template>
	<inertia-link v-if="link" :href="link" :class="['px-3 py-2 flex items-center', classes]">
		<i :class="['leading-6', icon]"></i>
		<span class="ml-3">{{ name }}</span>
	</inertia-link>
	<div v-else :class="[classes, 'relative']" @mouseleave="dropDownShow = false">
		<div
			:class="['flex flex-1 items-center cursor-pointer px-3 py-2']"
			@click="dropDownShow = !dropDownShow"
		>
			<i :class="['leading-6', icon]"></i>
			<span class="ml-3 w-full">{{ name }}</span>
			<i
				:class="[
					'feather mr-1',
					!dropDownActive ? 'icon-chevron-right' : 'icon-chevron-down',
				]"
			></i>
		</div>
		<div class="w-full py-1 overflow-hidden z-10" v-show="dropDownActive">
			<ul>
				<slot :dropDownActive="dropDownActive" />
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			name: { default: "Section Item", type: String },
			link: { default: false, type: [String, Boolean] },
			icon: { default: "feather icon-home", type: String },
			sideBarActive: Boolean,
		},
		data: () => ({
			dropDownShow: false,
			classes: "hover:bg-gray-200 hover:shadow-xl hover:border-gray-300 dark:hover:bg-gray-700",
		}),
		computed: {
			dropDownActive() {
				if (!this.sideBarActive) this.dropDownShow = false;
				return this.dropDownShow;
			},
		},
	};
</script>

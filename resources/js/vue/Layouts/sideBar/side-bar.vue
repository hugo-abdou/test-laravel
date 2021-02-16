<template>
	<div
		:class="[
			'bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-200 shadow-xl fixed z-50 top-2 bottom-2 left-0 ',
			'whitespace-nowrap duration-1000 rounded-r-lg overflow-x-hidden overflow-y-auto',
			sideBarActive ? 'w-56' : 'w-10',
		]"
		style="position: fixed"
		data-simplebar
		data-simplebar-auto-hide="false"
		@mouseenter="sideBarActive = true"
		@mouseleave="sideBarActive = false"
	>
		<div class="px-1 py-6 min-w-65">
			<logo />
		</div>
		<ul class="divide-y divide-gray-500">
			<Section v-for="(section, index) in sideBarLinks" :key="index">
				<section-link
					v-if="section"
					v-for="({ name, icon, url, sub_menu }, index) in section"
					:icon="icon"
					:link="url"
					:name="name"
					:key="index"
					:sideBarActive="sideBarActive"
				>
					<dropdown-link
						v-if="sub_menu"
						v-for="({ name, icon, url, img }, index) in sub_menu"
						:icon="icon"
						:link="url"
						:name="name"
						:img="img"
						:key="index"
					/>
				</section-link>
			</Section>
			<Section>
				<div class="text-sm p-10 text-center">copy Right hugo 2020</div>
			</Section>
		</ul>
	</div>
</template>

<script>
	import Search from "./search.vue";
	import SectionLink from "./section-link.vue";
	import DropdownLink from "./dropdown-link.vue";
	import Section from "./section";
	import Logo from "../logo.vue";
	export default {
		components: {
			Search,
			Section,
			SectionLink,
			DropdownLink,
			Logo,
		},
		data: () => ({
			sideBarActive: false,
		}),
		computed: {
			sideBarLinks() {
				return this.$page.props.menus.side_bar.map((item) => item.filter((item) => item));
			},
		},
		mounted() {
			console.log(simplebar);
		},
	};
</script>

<template>
	<div
		class="relative h-screen bg-gray-200 dark:bg-gray-700 duration-1000 pl-10"
		data-simplebar
		data-simplebar-auto-hide="false"
	>
		<top-navbar />
		<!-- Page Content -->

		<side-bar />
		<main class="py-24 mx-5">
			<slot> </slot>
			<toast
				:errorBags="$page.props.errorBags"
				:message="$page.props.message"
				:version="$page.version"
			/>
		</main>
	</div>
</template>

<script>
	import SideBar from "./sideBar/side-bar.vue";
	import TopNavbar from "./TopNavbar.vue";
	import "simplebar";
	import "simplebar/dist/simplebar.css";
	export default {
		components: { SideBar, TopNavbar },
	};
</script>


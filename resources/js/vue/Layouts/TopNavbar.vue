<template>
	<nav
		:class="[
			'bg-gray-50 border border-gray-100',
			'dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700',
			'fixed z-50 left-15 right-5 top-2 shadow-xl rounded-lg duration-1000',
		]"
	>
		<div class="mx-auto px-4 sm:px-6 lg:px-8 flex">
			<div class="flex items-center justify-between h-16 w-full">
				<!-- Pages Menu -->
				<search class="w-6/12" />
				<div class="hidden md:block">
					<div class="flex items-center">
						<!-- Profile dropdown -->
						<toggle-theme-mode />
						<div v-if="$page.props.auth" class="relative">
							<button
								class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid"
								id="user-menu"
								aria-label="User menu"
								aria-haspopup="true"
								@click="userDropdown = !userDropdown"
							>
								<img
									class="h-8 w-8 rounded-full object-cover"
									:src="$page.props.auth['photo-avatar']"
									alt="avatar"
								/>
							</button>
							<transition
								enter-active-class="transition ease-out duration-200"
								enter-class="transform opacity-0 scale-95"
								enter-to-class="transform opacity-100 scale-100"
								leave-active-class="transition ease-in duration-200"
								leave-class="transform opacity-100 scale-100"
								leave-to-class="transform opacity-0 scale-95"
							>
								<div
									@mouseleave="userDropdown = false"
									v-show="userDropdown"
									class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10"
								>
									<div
										class="rounded-md bg-white dark:bg-gray-800 shadow-xs overflow-hidden ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
									>
										<div v-for="(section, index) in actions" :key="index">
											<inertia-link
												v-for="(action, index) in section"
												:key="index"
												:href="action.url"
												:method="action.method || 'get'"
												class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 hover:bg-gray-100"
											>
												<i :class="`${action.icon} pr-1`"></i>
												{{ action.name }}
											</inertia-link>
										</div>
									</div>
								</div>
							</transition>
						</div>
						<template v-if="!$page.props.auth">
							<link-item tag="a" name="Login" :href="$routes('login')" />
							<link-item tag="a" name="Register" :href="$routes('register')" />
						</template>
					</div>
				</div>
				<div class="-mr-2 flex md:hidden">
					<!-- Mobile menu button -->
					<button
						class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white"
						@click="menuDropdown = !menuDropdown"
					>
						<!-- Menu open: "hidden", Menu closed: "block" -->
						<i v-if="!menuDropdown" class="feather icon-menu text-xl"></i>
						<!-- Menu open: "block", Menu closed: "hidden" -->
						<i v-if="menuDropdown" class="feather icon-x text-xl"></i>
					</button>
				</div>
			</div>
		</div>

		<!--
      Mobile menu, toggle classes based on menu state.

      Open: "block", closed: "hidden"
    -->
		<div
			class="md:hidden duration-300 overflow-y-scroll"
			:class="!menuDropdown ? 'hidden' : 'block'"
		>
			<div v-if="$page.props.auth" class="pt-4 pb-3 border-t border-gray-700">
				<div class="flex items-center px-5 space-x-3">
					<div class="flex-shrink-0">
						<img
							class="h-10 w-10 rounded-full"
							:src="$page.props.auth['photo-avatar']"
							:alt="$page.props.auth.name"
						/>
					</div>
					<div class="space-y-1">
						<div class="text-base font-medium leading-none text-white">
							{{ $page.props.auth.name }}
						</div>
					</div>
				</div>
				<div class="mt-3 px-2 space-y-1" v-for="(section, index) in actions" :key="index">
					<inertia-link
						tag="a"
						class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 flex justify-between"
						v-for="(action, index) in section"
						:key="index"
						:href="action.url"
						@success="change"
					>
						<span>{{ action.name }}</span>
						<i :class="action.icon"></i>
					</inertia-link>
				</div>
			</div>
		</div>
	</nav>
</template>

<script>
	import linkItem from "@vue/components/link-item";
	import Search from "./sideBar/search.vue";
	import ToggleThemeMode from "./toggle-theme-mode.vue";
	export default {
		components: {
			linkItem,
			Search,
			ToggleThemeMode,
		},
		data(vm) {
			return {
				userDropdown: false,
				menuDropdown: false,
			};
		},
		computed: {
			actions() {
				return this.$page.props.menus.actions;
			},
		},
		methods: {
			change() {
				menuDropdown = false;
			},
		},
	};
</script>

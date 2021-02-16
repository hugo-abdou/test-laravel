<template>
	<div>
		<transition
			enter-active-class="transition ease-out duration-200"
			enter-class="transform opacity-0 scale-95"
			enter-to-class="transform opacity-100 scale-100"
			leave-active-class="transition ease-in duration-200"
			leave-class="transform opacity-100 scale-100"
			leave-to-class="transform opacity-0 scale-95"
		>
			<card class="w-10/12 mx-auto">
				<template slot="title">
					<div class="flex items-center m-5 mb-8 space-x-8">
						<a
							href="#"
							@click.prevent="toggleComponent('edit-account')"
							:class="activeComponent == 'edit-account' ? activeLinkClass : LinkClass"
						>
							<i class="feather icon-user"></i>
							Account
						</a>
						<a
							href="#"
							:class="activeComponent == 'edit-info' ? activeLinkClass : LinkClass"
							@click.prevent="toggleComponent('edit-info')"
						>
							<i class="feather icon-info"></i>
							Information
						</a>
						<a
							href="#"
							:class="activeComponent == 'edit-media' ? activeLinkClass : LinkClass"
							@click.prevent="toggleComponent('edit-media')"
						>
							<i class="feather icon-image"></i>
							Media
						</a>
					</div>
				</template>
				<keep-alive>
					<component ref="component" :is="activeComponent" />
				</keep-alive>
			</card>
		</transition>
	</div>
</template>

<script>
	import EditProfile from '@store/EditProfile'; // store module
	import editAccount from '@vue/components/edit-account';
	import editInfo from '@vue/components/edit-info';
	import editMedia from '@vue/components/edit-media';

	export default {
		components: {
			editAccount,
			editInfo,
			editMedia,
		},
		props: ['errorBags', 'user'],
		data() {
			return {
				activeComponent: 'edit-account',
				activeLinkClass: 'pb-2 text-base text-gray-700 border-gray-600 border-b-2',
				LinkClass: 'pb-2 text-base text-gray-500 ',
			};
		},
		beforeCreate() {
			if (!this.$store.hasModule('editProfile')) {
				this.$store.registerModule('editProfile', EditProfile);
			}
			this.$store.commit('setDefaultData', this.$page.props.user);
		},
		methods: {
			toggleComponent(e) {
				this.activeComponent = e;
			},
		},
	};
</script>

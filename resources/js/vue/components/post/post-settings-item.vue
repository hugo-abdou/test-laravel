<template>
	<li class="p-4 bg-white shadow rounded duration-1000">
		<div
			class="w-full cursor-pointer"
			:class="{ 'mb-4': showDropDown }"
			@click="show_dropDown()"
		>
			<span v-text="name"></span>
			<div class="float-right pt-1">
				<slot name="nav" />
				<i
					class="feather"
					:class="{ 'icon-chevron-down': !showDropDown, 'icon-chevron-up': showDropDown }"
				></i>
			</div>
		</div>

		<div v-show="showDropDown">
			<slot />
		</div>
	</li>
</template>

<script>
	export default {
		props: ['name'],
		data() {
			return {
				showDropDown: false,
			};
		},
		methods: {
			show_dropDown() {
				this.showDropDown = !this.showDropDown;
				if (this.showDropDown) {
					this.$emit('dropDownActive');
				}
			},
		},
	};
</script>
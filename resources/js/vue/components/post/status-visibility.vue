<template>
	<post-settings-item name="Status & visibility">
		<ul class="space-y-2">
			<li class="flex items-center justify-between">
				<div class="flex items-center space-x-2">
					<i class="feather icon-eye"></i>
					<span>Visibility</span>
				</div>
				<select
					class="form-select focus:shadow-none py-0 cursor-pointer"
					v-model="visibilityData"
					@change="change"
				>
					<option value="public">Public</option>
					<option value="private">Private</option>
				</select>
			</li>
			<li class="flex items-center justify-between">
				<div for="disabled-comments" class="flex items-center space-x-2">
					<i class="feather icon-clock"></i>
					<span>Publish</span>
				</div>
				<input
					class="form-input py-0 px-1"
					v-model="publishData"
					type="datetime-local"
					@change="change"
				/>
			</li>
		</ul>
	</post-settings-item>
</template>
<script>
	import postSettingsItem from '@vue/components/post/post-settings-item';
	import { mapGetters } from 'vuex';
	export default {
		props: {
			visibility: {
				type: String,
				default: 'public',
			},
			publish: {
				type: String,
				default: null,
			},
		},
		components: { postSettingsItem },
		data(vm) {
			return {
				visibilityData: vm.visibility,
				publishData: vm.publish ? vm.publish.replace(' ', 'T') : '',
			};
		},
		methods: {
			change() {
				if (!this.publishData) {
					this.publishData = new Date().toISOString().replace('Z', '');
				}
				this.$emit('change', {
					visibility: this.visibilityData,
					publish: this.publishData,
				});
			},
		},
	};
</script>
<template>
	<post-settings-item name="Discussion">
		<template>
			<ul class="space-y-2">
				<li
					class="border-b p-2 border-transparent hover:border-gray-400 hover:bg-gray-200 rounded"
				>
					<div class="flex items-center justify-between">
						<label
							for="disable-comments"
							class="flex items-center space-x-2 cursor-pointer"
						>
							<i class="feather icon-message-square"></i>
							<span for="disables-comments">Disable Comments</span>
						</label>
						<input
							type="checkbox"
							class="form-checkbox"
							v-model="disableCommentsData"
							:checked="disableCommentsData"
							@change="toggleDisableComments"
							id="disable-comments"
						/>
					</div>
				</li>
			</ul>
		</template>
	</post-settings-item>
</template>
<script>
	import postSettingsItem from '@vue/components/post/post-settings-item';
	export default {
		components: { postSettingsItem },
		props: {
			disableComments: {
				type: Boolean,
				default: false,
			},
		},
		data(vm) {
			return {
				disableCommentsData: vm.disableComments,
			};
		},
		methods: {
			toggleDisableComments() {
				this.$emit('change', this.disableCommentsData);
			},
		},
	};
</script>
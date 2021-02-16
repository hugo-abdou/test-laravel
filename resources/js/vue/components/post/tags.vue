<template>
	<post-settings-item name="Tags" @dropDownActive="getTags">
		<template>
			<i
				slot="nav"
				v-show="tagsData.loading"
				class="animate-spin feather icon-loader inline-block mr-2 text-gray-800"
			></i>
			<ul class="relative" v-if="tagsData.data">
				<transition-group
					class="space-y-2"
					enter-active-class="transition ease-in duration-200"
					enter-class="transform opacity-0"
					enter-to-class="transform opacity-100"
				>
					<li v-for="tag in tagsData.data" :key="tag.id" class="min-w-px">
						<input
							@change="toggleCheckeTag(tag.id)"
							type="checkbox"
							class="form-checkbox mr-5"
							:id="`tag${tag.id}`"
							:checked="tag.checked"
						/>
						<label :for="`tag${tag.id}`" class="cursor-pointer">{{ tag.name }}</label>
					</li>
				</transition-group>
			</ul>
		</template>
	</post-settings-item>
</template>
<script>
	import postSettingsItem from '@vue/components/post/post-settings-item';
	export default {
		components: { postSettingsItem },
		props: ['tags'],
		data: () => {
			return {
				tagsData: {
					loading: false,
					loaded: false,
					data: [],
				},
			};
		},
		watch: {
			tags() {
				this.pushTags();
			},
		},
		methods: {
			getTags() {
				if (this.tagsData.loaded) return;
				this.tagsData.loading = true;
				this.$emit('getTags');
			},
			toggleCheckeTag(tag) {
				this.$emit('toggleCheckeTag', tag);
			},
			pushTags() {
				let tags = this.tags;
				let count = 0;
				let pushTags = setInterval(() => {
					if (tags && count < tags.length) {
						if (this.tagsData.loaded) {
							this.tagsData.data[count].checked = tags[count].checked;
							count++;
						} else {
							this.tagsData.data.push(tags[count]);
							count++;
						}
					} else {
						clearInterval(pushTags);
						this.tagsData.loading = false;
						this.tagsData.loaded = true;
					}
				}, 200);
			},
		},
	};
</script>

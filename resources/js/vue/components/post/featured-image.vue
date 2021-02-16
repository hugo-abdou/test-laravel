<template>
	<post-settings-item name="Featured Image" @dropDownActive="getImages()">
		<i
			slot="nav"
			v-show="imgs.loading"
			class="animate-spin feather icon-loader inline-block mr-2 text-gray-800"
		></i>
		<ul>
			<li v-if="!imgs.data.length" class="h-15 overflow-hidden flex items-center rounded-md">
				<div class="w-32 h-full bg-gray-400"></div>
				<div class="h-full w-8/12 bg-gray-300">
					<div class="bg-gray-400 h-3 mb-1 ml-4 mt-3 rounded w-4/12 animate-pulse"></div>
					<div class="bg-gray-500 h-3 ml-4 rounded w-8/12 animate-pulse"></div>
				</div>
			</li>
			<transition-group
				class="space-y-2"
				enter-active-class="transition ease-in duration-200"
				enter-class="transform opacity-0"
				enter-to-class="transform opacity-100"
			>
				<li
					class="h-15 overflow-hidden flex items-center rounded-md"
					v-for="img in imgs.data"
					:key="img.id"
				>
					<img class="object-cover w-32" :src="img.url" />
					<div class="h-full w-8/12 bg-gray-300">
						<div class="bg-gray-400 h-3 mb-1 ml-4 mt-3 rounded w-4/12"></div>
						<div class="bg-gray-500 h-3 ml-4 rounded w-8/12"></div>
					</div>
				</li>
			</transition-group>
		</ul>
	</post-settings-item>
</template>
<script>
	import postSettingsItem from '@vue/components/post/post-settings-item';
	import { Inertia } from '@inertiajs/inertia';
	export default {
		components: { postSettingsItem },
		data: () => {
			return {
				imgs: {
					loading: false,
					loaded: false,
					data: [],
				},
			};
		},
		methods: {
			pushImgs(page) {
				let images = page.props.images.post_imgs;
				let count = 0;
				let pushImages = setInterval(() => {
					if (count < images.length) {
						this.imgs.data.push(images[count]);
						count++;
					} else {
						clearInterval(pushImages);
						this.imgs.loading = false;
					}
				}, 200);
			},
			getImages() {
				if (this.imgs.loaded) return;
				Inertia.get(this.$routes('post.edit', [this.$page.props.post.data.id]), null, {
					preserveScroll: true,
					preserveState: true,
					only: ['images'],
					onStart: () => {
						this.imgs.loading = true;
					},
					onSuccess: page => {
						this.pushImgs(page);
					},
				});
				this.imgs.loaded = true;
			},
			deleteImg(cat) {
				Inertia.put(
					this.$routes('post.deleteImageFromPost', [this.$page.props.post.data.id]),
					{ img: img },
					{
						preserveScroll: true,
						preserveState: true,
						only: ['images'],
					}
				);
			},
		},
	};
</script>
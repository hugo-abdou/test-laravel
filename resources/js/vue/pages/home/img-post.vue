<template>
	<div
		:class="[
			'relative min-w-72 min-h-72 w-full overflow-hidden rounded-md shadow-md',
			spanGridClass,
		]"
	>
		<!-- overlay -->
		<ul class="h-full w-full">
			<img
				@load="loadImg"
				v-for="(img, i) in post.images"
				:key="img.id"
				:ref="i"
				:src="img.url"
				class="absolute top-0 h-full w-full object-cover object-center duration-1000"
			/>
		</ul>

		<span
			v-if="post.is_new_post"
			class="absolute top-2 left-2 text-xs bg-blue-200 px-2 rounded-full text-blue-600 font-semibold shadow-md"
			>NUW</span
		>
		<i
			class="feather icon-chevron-right right-2 absolute bottom-1/2 text-gray-50 p-1 rounded-full bg-gray-900 bg-opacity-50 shadow cursor-pointer"
			@click="nextImg"
		>
		</i>
		<i
			class="feather icon-chevron-left left-2 absolute bottom-1/2 text-gray-50 p-1 rounded-full bg-gray-900 bg-opacity-50 shadow cursor-pointer"
			@click="prevImg"
		>
		</i>
		<div class="absolute bottom-0 w-full p-2">
			<div
				class="duration-1000 text-gray-600 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:bg-opacity-50 bg-opacity-70 shadow-md p-3 rounded-lg"
			>
				<div class="flex items-center justify-between text-xs mb-2">
					<inertia-link :href="post.user.url" class="flex items-center">
						<div class="relative h-8 w-8">
							<img
								:src="post.user.avatar"
								class="absolute inset-0 h-full w-full object-cover rounded-full shadow-md border"
							/>
						</div>
						<div class="ml-2 font-semibold">
							<span class="block text-sm leading-5">{{ post.user.name }}</span>

							<span class="text-xs">{{ post.created_at }} </span>
						</div>
					</inertia-link>
					<div>
						<span class="flex">
							<star v-for="i in 5" :key="i" class="w-3 text-blue-400" />
						</span>
						<span class="mt-2 inline-block">3K reviews</span>
					</div>
				</div>

				<h2 class="text-2xl font-bold">{{ post.title }}</h2>
			</div>
		</div>
	</div>
</template>

<script>
	import star from "@vue/components/star";
	export default {
		components: {
			star,
		},

		props: {
			post: Object,
		},
		data() {
			return {
				activeImg: 0,
				is_loaded: false,
				spanGridClass: null,
			};
		},
		computed: {},
		methods: {
			nextImg() {
				if (this.activeImg == this.post.images.length - 1) {
					this.activeImg = 0;
				} else {
					this.activeImg++;
				}
				this.hideImages();
			},
			prevImg() {
				if (this.activeImg == 0) {
					this.activeImg = this.post.images.length - 1;
				} else {
					this.activeImg--;
				}
				this.hideImages();
			},
			hideImages() {
				for (const key in this.$refs) {
					this.$refs[key][0].classList.add("opacity-0");
					if (parseInt(key) == this.activeImg)
						this.$refs[key][0].classList.remove("opacity-0");
				}
			},
			loadImg(e) {
				let image = e.path[0];
				if (this.is_loaded) return;
				if (image.naturalHeight < image.naturalWidth) {
					this.spanGridClass = "md:col-span-2";
				} else {
					this.spanGridClass = "md:row-span-2";
				}
				this.is_loaded = true;
			},
		},
	};
</script>
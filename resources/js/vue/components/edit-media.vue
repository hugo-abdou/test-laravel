<template>
	<div class="my-8">
		<ul class="flex flex-wrap">
			<li class="w-4/12 inline-block p-2 relative">
				<div class="w-full text-center pr-13 mb-2">Colecti</div>
				<ul class="relative w-full h-40 ">
					<li class="overflow-hidde w-full h-9/12 my-3 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
					<li class="overflow-hidde w-11/12 h-10/12 my-2 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/25.jpg"
						/>
					</li>
					<li class="overflow-hidde w-10/12 h-11/12 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
				</ul>
			</li>
			<li class="w-4/12 inline-block p-2 relative">
				<div class="w-full text-center pr-13 mb-2">Colection A</div>
				<ul class="relative w-full h-40 ">
					<li class="overflow-hidde w-full h-9/12 my-3 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
					<li class="overflow-hidde w-11/12 h-10/12 my-2 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/25.jpg"
						/>
					</li>
					<li class="overflow-hidde w-10/12 h-11/12 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
				</ul>
			</li>
			<li class="w-4/12 inline-block p-2 relative">
				<div class="w-full text-center pr-13 mb-2">Colection A</div>
				<ul class="relative w-full h-40 ">
					<li class="overflow-hidde w-full h-9/12 my-3 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
					<li class="overflow-hidde w-11/12 h-10/12 my-2 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/25.jpg"
						/>
					</li>
					<li class="overflow-hidde w-10/12 h-11/12 absolute top-0 shadow-lg">
						<img
							class="w-full h-full object-cover rounded-md"
							src="../../../images/profile/post-media/2.jpg"
						/>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="flex flex-wrap transition duration-1000">
			<li
				class="w-4/12 h-48 inline-block p-2 "
				v-for="(image, index) in images"
				:key="image.id"
			>
				<div class="w-full h-full overflow-hidden relative p-0.5 ">
					<img
						class="w-full h-full rounded shadow hover:opacity-75 object-cover"
						:src="`/storage/${image.url}`"
					/>
					<div class="absolute right-5 top-5 ">
						<button
							@click="deleteImage(image.id)"
							type="button"
							class="px-2 py-0.5 rounded-md focus:outline-none bg-gray-800 bg-opacity-50  hover:bg-opacity-100 border border-gray-700 font-semibold text-gray-400 transition ease-in-out duration-150 active:animate-ping"
						>
							<i class="feather icon-trash-2"></i>
						</button>
						<button
							@click="showImage(index)"
							type="button"
							class="px-2 py-0.5 rounded-md focus:outline-none bg-gray-800 bg-opacity-50  hover:bg-opacity-100 border border-gray-700 font-semibold text-gray-400 transition ease-in-out duration-150 active:animate-ping"
						>
							<i class="feather icon-eye"></i>
						</button>
					</div>
					<div
						v-if="image.role"
						class="-rotate-45 -translate-x-7 absolute bg-teal-400 font-bold h-7 shadow-lg text-center text-gray-800 top-0 transform translate-y-3 w-28"
					>
						<span>{{ image.role }}</span>
					</div>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	import appLayout from '@vue/Layouts/AppLayout';
	import { Inertia } from '@inertiajs/inertia';
	export default {
		layout: (h, page) => {
			return h(appLayout, [page]);
		},
		computed: {
			images() {
				return this.$page.props.images;
			},
		},
		methods: {
			deleteImage(img) {
				Inertia.delete(this.$routes('media.delete', [img]), {
					preserveState: true,
					preserveScroll: true,
					only: ['images', 'auth'],
				});
			},
			showImage(index) {
				let imgs = this.images;
				this.$store.commit('showGalleryModel', { index, imgs });
			},
		},
	};
</script>

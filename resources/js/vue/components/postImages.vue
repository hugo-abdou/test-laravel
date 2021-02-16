<template>
	<div class="pb-7/12 relative bg-gray-200">
		<div class="grid grid-cols-2 grid-rows-2 gap-1 h-full absolute w-full top-0 ">
			<div class="w-full h-full relative" :class="classList[0]">
				<img :src="images[0].url" class="w-full h-full object-cover" />
				<div
					class="absolute inset-0 w-full h-full bg-gray-700 bg-opacity-0 hover:bg-opacity-50 flex justify-center items-center cursor-pointer duration-700"
				></div>
			</div>
			<div v-if="count >= 2" class="w-full h-full relative" :class="classList[1]">
				<img :src="images[1].url" class="w-full h-full object-cover" />
				<div
					class="absolute inset-0 w-full h-full bg-gray-700 bg-opacity-0 hover:bg-opacity-50 flex justify-center items-center cursor-pointer  duration-700"
				></div>
			</div>
			<div v-if="count >= 3" class="w-full h-full relative" :class="classList[2]">
				<img :src="images[2].url" class="w-full h-full object-cover" />
				<div
					class="absolute inset-0 w-full h-full bg-gray-700 hover:bg-opacity-50 flex justify-center items-center cursor-pointer  duration-700"
					:class="{ 'bg-opacity-50': count > 3, 'bg-opacity-0 ': count == 3 }"
				>
					<span v-if="count > 3" class="text-gray-100 text-2xl font-semibold">
						+{{ count - 3 }}
					</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['images', 'count'],
		computed: {
			classList() {
				switch (this.count) {
					case 1:
						return ['row-span-2 col-span-2'];
						break;
					case 2:
						return ['row-start-1 row-end-3', 'row-start-1 row-end-3'];
						break;
					default:
						return ['row-start-1 row-end-3'];
						break;
				}
			},
		},
	};
</script>

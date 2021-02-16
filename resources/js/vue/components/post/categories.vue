<template>
	<post-settings-item name="Categories" @dropDownActive="getCats">
		<template>
			<i
				slot="nav"
				v-show="cats.loading"
				class="animate-spin feather icon-loader inline-block mr-2 text-gray-800"
			></i>
			<ul class="relative" v-if="cats.data">
				<transition-group
					class="space-y-2"
					enter-active-class="transition ease-in duration-200"
					enter-class="transform opacity-0"
					enter-to-class="transform opacity-100"
				>
					<li v-for="(cat, index) in cats.data" :key="`cat${index}`" class="min-w-px">
						<input
							type="checkbox"
							class="form-checkbox mr-5"
							@change="toggleCheckeCat(cat.id)"
							:id="`cat${cat.id}`"
							:checked="cat.checked"
						/>
						<label :for="`cat${cat.id}`" class="cursor-pointer">{{ cat.name }}</label>
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
		props: {
			categories: { type: Array },
		},
		data() {
			return {
				cats: {
					loading: false,
					data: [],
					loaded: false,
				},
			};
		},

		watch: {
			categories() {
				this.pushCats();
			},
		},
		methods: {
			getCats() {
				if (this.cats.loaded) return;
				this.cats.loading = true;
				this.$emit('getCats');
			},
			toggleCheckeCat(cat) {
				this.$emit('toggleCheckeCat', cat);
			},
			pushCats() {
				let categories = this.categories;
				let count = 0;
				let pushCats = setInterval(() => {
					if (categories && count < categories.length) {
						if (this.cats.loaded) {
							this.cats.data[count].checked = categories[count].checked;
							count++;
						} else {
							this.cats.data.push(categories[count]);
							count++;
						}
					} else {
						clearInterval(pushCats);
						this.cats.loading = false;
						this.cats.loaded = true;
					}
				}, 200);
			},
		},
	};
</script>

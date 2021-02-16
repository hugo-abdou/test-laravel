<template>
	<div class="grid grid-cols-3 grid-rows-none gap-3">
		<!-- post form -->
		<div class="col-span-2">
			<card>
				<div class="max-w-2xl mx-auto">
					<i class="feather icon-help-circle"></i>
				</div>
				<Editor
					placeholder="Type some tings cool..."
					:minHeight="100"
					:tools="Editor_tools"
					@save="save"
				/>
			</card>
		</div>
		<!-- post settings -->
		<div class="col-span-1">
			<ul class="space-y-3">
				<status-visibility @change="changeStatus_vesibility" />
				<categories
					:categories="cats"
					@getCats="getCats"
					@toggleCheckeCat="toggleCheckeCat"
				/>
				<tags :tags="tags" @toggleCheckeTag="toggleCheckeTag" @getTags="getTags" />
				<discussion @change="toggleDisableComments" />
			</ul>
		</div>
	</div>
</template>
<script>
	import Editor_tools from '@config/editorTools';
	import Editor from '@vue/components/editor';
	import StatusVisibility from '@vue/components/post/status-visibility';
	import Categories from '@vue/components/post/categories';
	import Tags from '@vue/components/post/tags';
	import Discussion from '@vue/components/post/discussion';
	import { Inertia } from '@inertiajs/inertia';
	export default {
		components: {
			Editor,
			StatusVisibility,
			Categories,
			Tags,
			Discussion,
		},
		data() {
			return {
				Editor_tools: Editor_tools,
				cats: [],
				tags: [],
				disable_comments: false,
				publish: null,
				visibility: 'public',
			};
		},
		methods: {
			getCats() {
				this.cats = this.$page.props.categories;
			},
			getTags() {
				this.tags = this.$page.props.tags;
			},
			toggleDisableComments(data) {
				this.disable_comments = data;
			},

			toggleCheckeCat(id) {
				this.cats = this.cats.map(cat => {
					if (cat.id == id) {
						return { ...cat, checked: !cat.checked };
					}
					return cat;
				});
			},
			toggleCheckeTag(id) {
				this.tags = this.tags.map(tag => {
					if (tag.id == id) {
						return { ...tag, checked: !tag.checked };
					}
					return tag;
				});
			},
			changeStatus_vesibility({ publish, visibility }) {
				this.publish = publish;
				this.visibility = visibility;
			},
			save({ title, data }) {
				let post = {
					title: title,
					content: data,
					disable_comments: this.disable_comments,
					visibility: this.visibility,
					categories: this.cats,
					tags: this.tags,
					publish:
						this.publish == null ? new Date().toISOString().replace('Z', '') : this.publish,
				};
				Inertia.post(this.$routes('post.store'), post, {
					preserveScroll: true,
					preserveState: true,
				});
			},
		},
	};
</script>

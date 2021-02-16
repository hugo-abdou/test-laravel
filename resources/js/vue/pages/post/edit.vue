<template>
	<div class="grid grid-cols-3 grid-rows-none gap-3">
		<!-- post form -->
		<div class="col-span-2">
			<card>
				<div class="max-w-2xl mx-auto">
					<i class="feather icon-help-circle"></i>
				</div>
				<Editor
					:title="$page.props.post.data.title"
					placeholder="Type some tings cool..."
					:minHeight="100"
					:data="editorData"
					:tools="Editor_tools"
					@save="save"
				/>
			</card>
		</div>
		<!-- post settings -->
		<div class="col-span-1">
			<ul class="space-y-3">
				<status-visibility
					:visibility="$page.props.post.data.visibility"
					:publish="$page.props.post.data.publish"
					@change="changeStatus_vesibility"
				/>
				<categories
					:categories="cats"
					@toggleCheckeCat="toggleCheckeCat"
					@getCats="getCats"
				/>
				<tags :tags="tags" @toggleCheckeTag="toggleCheckeTag" @getTags="getTags" />
				<discussion
					:disableComments="$page.props.post.data.disable_comments"
					@change="toggleDisableComments"
				/>
			</ul>
		</div>
	</div>
</template>

<script>
	import { Inertia } from '@inertiajs/inertia';
	import Editor_tools from '@config/editorTools';
	import Editor from '@vue/components/editor';
	import EditPost from '@store/editPost';
	import { createNamespacedHelpers } from 'vuex';
	const { mapGetters } = createNamespacedHelpers('editPost');
	// components
	import StatusVisibility from '@vue/components/post/status-visibility';
	import Categories from '@vue/components/post/categories';
	import Tags from '@vue/components/post/tags';
	import Discussion from '@vue/components/post/discussion.vue';

	export default {
		components: { Editor, StatusVisibility, Categories, Tags, Discussion },
		props: ['post'],
		beforeCreate() {
			let moduleName = 'editPost';
			if (!this.$store.state[moduleName]) this.$store.registerModule(moduleName, EditPost);
			this.$store.commit('editPost/setDefaultData', this.$page.props.post);
		},
		data(vm) {
			return {
				Editor_tools: Editor_tools,
				cats: [],
				tags: [],
			};
		},
		computed: {
			...mapGetters(['editorData']),
		},
		methods: {
			changeStatus_vesibility(data) {
				this.$store.commit('editPost/changeStatus_vesibility', data);
			},
			//categories section
			getCats() {
				Inertia.get(
					this.$routes('post.edit', [this.post.data.id]),
					{},
					{
						preserveScroll: true,
						preserveState: true,
						only: ['categories'],
						onSuccess: page => {
							this.cats = page.props.categories;
						},
					}
				);
			},
			toggleCheckeCat(id) {
				Inertia.put(
					this.$routes('post.toggelCategory', [this.post.data.id]),
					{ cat: id },
					{
						preserveScroll: true,
						preserveState: true,
						only: ['categories'],
						onSuccess: page => {
							this.cats = page.props.categories;
						},
					}
				);
			},
			// tags section
			getTags() {
				Inertia.get(
					this.$routes('post.edit', [this.post.data.id]),
					{},
					{
						preserveScroll: true,
						preserveState: true,
						only: ['tags'],
						onSuccess: page => {
							this.tags = page.props.tags;
						},
					}
				);
			},
			toggleCheckeTag(id) {
				Inertia.put(
					this.$routes('post.toggelTag', [this.post.data.id]),
					{ tag: id },
					{
						preserveScroll: true,
						preserveState: true,
						only: ['tags'],
						onSuccess: page => {
							this.tags = page.props.tags;
						},
					}
				);
			},
			toggleDisableComments(val) {
				this.$store.commit('editPost/toggleDisableComments', val);
			},
			save(data) {
				this.$store.dispatch('editPost/save', data);
			},
		},
	};
</script>

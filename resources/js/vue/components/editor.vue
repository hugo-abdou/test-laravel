<template>
	<div class="max-w-2xl mx-auto border-4 p-5 rounded-lg border-dashed h-full">
		<input
			class="form-input text-4xl font-semibold p-0 border-none focus:shadow-none w-full mb-5"
			placeholder="Title..."
			type="text"
			v-model="dataTitle"
		/>
		<div id="editorJs"></div>
		<button
			@click="save"
			type="submit"
			class="float-right mt-10 active:shadow-inner bg-blue-400 border-2 border-blue-400 border-solid py-1 px-2 rounded shadow focus:outline-none text-white"
		>
			save
		</button>
	</div>
</template>

<script>
	import editorJs from '@editorjs/editorjs';
	export default {
		props: {
			title: { type: String },
			data: { type: Object },
			tools: { type: Object },
			placeholder: { type: String, default: 'Type some tings cool ....' },
			minHeight: { type: Number, default: 50 },
		},
		data(vm) {
			return {
				dataTitle: vm.title,
				editor: new editorJs({
					holder: 'editorJs',
					tools: vm.tools,
					data: vm.data,
					placeholder: vm.placeholder,
					minHeight: vm.minHeight,
					onChange: data => {
						this.$emit('change', data);
					},
				}),
			};
		},
		methods: {
			save() {
				this.editor.save().then(res => {
					this.$emit('save', {
						title: this.dataTitle,
						data: res,
					});
				});
			},
		},
	};
</script>
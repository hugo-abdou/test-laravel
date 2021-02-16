<template>
	<div>
		<div class="flex flex-wrap md:flex-no-wrap md:space-x-8">
			<div class="w-full md:w-6/12 space-y-6">
				<div>
					<label
						for="name"
						class="text-gray-800 block mb-2"
					>User Name </label>
					<form-input
						placeholder="type your Full Name"
						required
						name="name"
						type="text"
					/>
				</div>
				<div>
					<label
						for="slug"
						class="text-gray-800 block mb-2"
					>User Slug </label>
					<form-input
						name="slug"
						placeholder="exampl-exampl"
						disabled
						type="text"
					/>
				</div>
			</div>
			<div class="w-full md:w-6/12 space-y-6 mt-8 md:mt-0">
				<div>
					<label
						for="email"
						class="text-gray-800 block mb-2"
					>Email</label>
					<form-input
						placeholder="type a email"
						required
						name="email"
						type="email"
					/>
				</div>
				<div>
					<label
						for="status"
						class="text-gray-800 block mb-2"
					>Status</label>
					<form-input
						disabled
						name="status"
						type="text"
					/>
				</div>
			</div>
		</div>
		<div class="w-full mt-8 mx-auto">
			<permissions />
		</div>
		<div class="w-12/12 mt-6 mr-6 text-right">
			<btn
				type="submit"
				class="py-2 px-4 text-lg"
				@click="save"
			>
				SAVE
			</btn>
		</div>
	</div>
</template>

<script>
	import formSelect from '@vue/components/form-select';
	import formInput from '@vue/components/form-input';
	import permissions from '@vue/components/permissions';
	export default {
		components: {
			formSelect,
			formInput,
			permissions,
		},
		methods: {
			save() {
				this.$store.dispatch('saveData');
			},
		},
	};
</script>

<template>
	<div>
		<div class="flex flex-wrap md:flex-no-wrap md:space-x-8">
			<!-- col 1 -->
			<div class="w-full md:w-6/12 space-y-6">
				<h1 class="text-gray-700 font-semibold text-xl">
					<i class="feather icon-user"></i>
					Personal Information
				</h1>
				<div>
					<label
						for="date"
						class="text-gray-800 block mb-2"
					>Birth date </label>
					<form-input
						name="date"
						type="date"
					/>
				</div>
				<div>
					<label
						for="mobile"
						class="text-gray-800 block mb-2"
					>Mobile</label>
					<form-input
						placeholder="+2524282429"
						name="mobile"
						type="text"
					/>
				</div>
				<div>
					<label
						for="website"
						class="text-gray-800 block mb-2"
					>Website </label>
					<form-input
						placeholder="https://exampl.com"
						name="website"
						type="text"
					/>
				</div>
				<div>
					<label
						for="languages"
						class="text-gray-800 block mb-2"
					>Languages </label>
					<form-multiple-select name="languages" />
				</div>
				<div>
					<label
						f
						class="text-gray-800 block mb-2"
					>Gender </label>
					<div class="flex items-center justify-start space-x-4">
						<div class="flex justify-between">
							<form-input
								type="radio"
								id="male"
								name="gender"
								value="male"
							/>
							<label
								for="male"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>Male
							</label>
						</div>
						<div class="flex justify-between">
							<form-input
								type="radio"
								id="female"
								name="gender"
								value="female"
							/>
							<label
								for="female"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>female
							</label>
						</div>
						<div class="flex justify-between">
							<form-input
								type="radio"
								id="other"
								name="gender"
								value="other"
							/>
							<label
								for="other"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>other
							</label>
						</div>
					</div>
				</div>
				<div>
					<label
						f
						class="text-gray-800 block mb-2"
					>Contact Options </label>
					<div class="flex items-center justify-start space-x-4">
						<div class="flex justify-between">
							<form-input
								name="contactOptions"
								type="checkbox"
								id="email"
								value="email"
							/>
							<label
								for="email"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>Email
							</label>
						</div>
						<div class="flex justify-between">
							<form-input
								name="contactOptions"
								type="checkbox"
								id="message"
								value="message"
							/>
							<label
								for="message"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>Message
							</label>
						</div>
						<div class="flex justify-between">
							<form-input
								name="contactOptions"
								type="checkbox"
								id="phone"
								value="phone"
							/>
							<label
								for="phone"
								class="cursor-pointer text-gray-600 mb-2 ml-1"
							>Phone
							</label>
						</div>
					</div>
				</div>
			</div>
			<!-- col 2 -->
			<div class="w-full md:w-6/12 space-y-6 mt-8 md:mt-0">
				<h1 class="text-gray-700 font-semibold text-xl">
					<i class="feather icon-map-pin"></i>
					Address
				</h1>
				<div>
					<label
						for="address_1"
						class="text-gray-800 block mb-2"
					>Address Line 1</label>
					<form-input
						placeholder="A-65, Belvedere Streets"
						name="address_1"
						type="text"
					/>
				</div>
				<div>
					<label
						for="address_2"
						class="text-gray-800 block mb-2"
					>Address Line 2</label>
					<form-input
						placeholder="A-65, Belvedere Streets"
						name="address_2"
						type="text"
					/>
				</div>
				<div>
					<label
						for="postcode"
						class="text-gray-800 block mb-2"
					>Postcode</label>
					<form-input
						placeholder="50502"
						name="postcode"
						type="text"
					/>
				</div>
				<div>
					<label
						for="city"
						class="text-gray-800 block mb-2"
					>City</label>
					<form-input
						placeholder="New York"
						name="city"
						type="text"
					/>
				</div>
				<div>
					<label
						for="state"
						class="text-gray-800 block mb-2"
					>State</label>
					<form-input
						placeholder="New York"
						name="state"
						type="text"
					/>
				</div>
				<div>
					<label
						for="country"
						class="text-gray-800 block mb-2"
					>Country</label>
					<form-input
						placeholder="United Kingdom"
						name="country"
						type="text"
					/>
				</div>
			</div>
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
	import formInput from '@vue/components/form-input';
	import formMultipleSelect from '@vue/components/form-multiple-select';

	export default {
		components: {
			formInput,
			formMultipleSelect,
		},
		methods: {
			save() {
				this.$store.dispatch('saveData');
			},
		},
	};
</script>

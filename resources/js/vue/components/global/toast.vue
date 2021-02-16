<template>
	<div class="fixed top-20 left-15 space-y-2">
		<transition
			v-for="(error, index) in errors"
			:key="index"
			class="space-y-2"
			enter-active-class="all ease-in duration-200"
			enter-class="transform opacity-0  -translate-x-15"
			enter-to-class="transform opacity-100  translate-x-0.5"
			leave-active-class="all ease-out duration-200"
			leave-class="transform translate-x-0.5"
			leave-to-class="transform  -translate-x-15"
		>
			<message :id="index" :message="error.msg" type="error" />
		</transition>
		<transition
			enter-active-class="all ease-in duration-200"
			enter-class="transform opacity-0  -translate-x-15"
			enter-to-class="transform opacity-100  translate-x-0.5"
			leave-active-class="all ease-out duration-200"
			leave-class="transform translate-x-0.5"
			leave-to-class="transform  -translate-x-15"
		>
			<message v-if="message_data" :message="message_data" :id="1" type="success" />
		</transition>
	</div>
</template>

<script>
	export default {
		props: ["errorBags", "message", "version"],
		data(vm) {
			return {
				errors: [],
				message_data: false,
			};
		},
		watch: {
			errorBags() {
				this.errors = [];
				let object = this.errorBags;
				let errors = [];
				for (const key in object) {
					if (Object.hasOwnProperty.call(object, key)) {
						const element = object[key];
						errors.push({ msg: element });
					}
				}
				let count = 0;
				let pushError = setInterval(() => {
					if (errors && count < errors.length) {
						this.errors.push(errors[count]);
						count++;
					} else {
						clearInterval(pushError);
					}
				}, 200);
			},
			message() {
				this.message_data = this.message;
			},
			version() {
				console.log("test");
			},
		},
	};
</script>
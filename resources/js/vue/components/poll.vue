<template>
	<li>
		<div class="mt-6 flex items-center justify-between">
			<div class="flex items-center">
				<input
					name="Polls"
					type="radio"
					class="form-radio h-4 w-4 text-blue-500 transition duration-150 ease-in-out"
				/>
				<label for="remember_me" class="ml-2 block text-sm leading-5">Remember me</label>
			</div>
			<span>56%</span>
		</div>
		<div class="mt-3 w-full h-2 rounded overflow-hidden bg-blue-200">
			<div class="w-1/3 h-2 bg-blue-500 rounded-r"></div>
		</div>
		<users-images class="mt-2" />
	</li>
</template>

<script>
	import imageUsersListVue from "./image-users-list.vue";
	export default {
		components: { "users-images": imageUsersListVue },
	};
</script>
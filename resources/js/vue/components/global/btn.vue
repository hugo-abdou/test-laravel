<template>
<button :type="type" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none active:border-gray-900 active:shadow-outline-gray transition ease-in-out duration-150" @click="click">
    <slot></slot>
</button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "submit"
        }
    },
    methods: {
        click() {
            this.$emit("click");
        }
    }
};
</script>

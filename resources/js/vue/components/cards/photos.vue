<template>
    <card class="w-full">
        <template slot="title">
            <span>Latest Photos</span>
            <i class="feather icon-more-horizontal float-right pt-2 pr-2"></i>
        </template>
        <template>
            <ul class="flex flex-wrap justify-center">
                <li
                    class="w-24 h-24 overflow-hidden inline-block p-1"
                    v-for="image in images"
                    :key="image.id"
                >
                    <img
                        class="w-full h-full object-cover rounded shadow hover:opacity-75"
                        :src="image.url"
                    />
                </li>
            </ul>
        </template>
    </card>
</template>

<script>
export default {
    props: ['images'],
};
</script>

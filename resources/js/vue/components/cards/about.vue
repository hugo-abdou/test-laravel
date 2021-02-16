<template>
    <card class="w-full">
        <template slot="title">
            <span>About</span>
        </template>
        <template>
            <p class="py-2 text-gray-700">
                aTart I love sugar plum I love oat cake. Sweet roll caramels I love jujubes. Topping
                cake wafer.
            </p>
            <p class="py-2" v-if="user.created_at">
                Joined:<span class="text-gray-700"> {{ user.created_at }}</span>
            </p>
            <p class="py-2" v-if="user.country && user.state">
                Lives In:
                <span class="text-gray-700"> {{ user.country + ', ' + user.state }}</span>
            </p>
            <p class="py-2" v-if="user.email">
                Email:<span class="text-gray-700"> {{ user.email }}</span>
            </p>
        </template>
    </card>
</template>

<script>
export default {
    props: ['user'],
};
</script>

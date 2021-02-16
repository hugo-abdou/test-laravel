<template>
<div class="rounded px-6 py-2 border border-gray-300">
    <h1 class="text-2xl p-4 text-gray-600">
        <i class="feather icon-lock"></i>
        <span>Permission</span>
    </h1>
    <hr />
    <div class="flex flex-col mt-4">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        Roles
                    </th>
                    <td v-for="(permission, index) in permissions" :key="index" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        {{ permission }}
                    </td>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr v-for="(role, key, index) in roles" :key="index">
                    <th class="px-6 py-4 text-left text-sm leading-5 font-medium text-gray-700">
                        {{ key }}
                    </th>
                    <template v-for="(permission, index) in permissions">
                        <td class="px-6 py-4" :key="index">
                            <input class="form-checkbox text-gray-400" disabled type="checkbox" :name="key" :value="permission" :checked="
                                        role.permissions.find(
                                            p => p == permission
                                        )
                                    " />
                        </td>
                    </template>
                </tr>
                <!-- More rows... -->
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    methods: {},
    computed: {
        permissions() {
            return this.$store.state.editProfile.permissions;
        },
        roles() {
            return this.$store.state.editProfile.roles;
        }
    }
};
</script>

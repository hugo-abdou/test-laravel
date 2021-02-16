<template>
<div class="relative">
    <span class="inline-block w-full rounded-md">
        <button type="button" class="appearance-none w-full rounded relative px-3 py-2 border font-medium border-gray-300 placeholder-gray-500 text-gray-600 focus:outline-none focus:shadow-outline-blue focus:z-10 sm:text-sm sm:leading-5" @click="boxShow = !boxShow">
            <div class="flex items-center space-x-3">
                <span class="block truncate">{{ select }}</span>
            </div>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <i class="feather icon-chevron-down"></i>
            </span>
        </button>
    </span>

    <div v-show="boxShow" @mouseleave="boxShow = false" class="absolute mt-1 w-full rounded-md bg-white shadow-lg">
        <ul class="max-h-56 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
            <li
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 h-10 hover:text-white hover:bg-indigo-300"
                @click="selected"
                v-for="(item, index) in selectList"
                :key="index">
                <span class="block truncate absolute w-full h-full py-2 pl-3 pr-9 top-0 right-0 bg-transparent z-50">
                    {{ item }}
                </span>

                <span class="absolute inset-y-0 right-0 flex items-center pr-4">
                    <i v-show="select == item" class="feather icon-check"></i>
                    <input :name="name" type="radio" class="form-checkbox hidden" :value="item" />
                </span>
            </li>
            <!-- More options... -->
        </ul>
    </div>
</div>
</template>

<script>
export default {
    props: ["name"],
    data() {
        return {
            select: "" || `select a ${this.name}`,
            boxShow: false
        };
    },
    computed: {
        selectList() {
            return this.$store.state.editProfile["select_" + this.name];
        }
    },
    methods: {
        selected(e) {
            e.target.nextElementSibling.children[1].checked = true;
            this.select = e.target.nextElementSibling.children[1].value;
            this.boxShow = false;
            this.$store.commit("setFormData", {
                name: this.name,
                data: this.select
            });
        }
    }
};
</script>

<template>
<div class="relative">
    <span class="inline-block w-full rounded-md">
        <button type="button" class="appearance-none w-full rounded relative px-3 py-1 border font-medium border-gray-300 placeholder-gray-500 text-gray-600 focus:outline-none focus:shadow-outline-blue focus:z-10 sm:text-sm sm:leading-5" @click="boxShow = !boxShow">
            <div class="flex items-center flex-wrap">
                <template v-if="typeof this.select == 'object'">
                    <span class="block bg-blue-400 mr-2 my-0.5 px-4 py-1 rounded text-gray-100" v-for="(value, index) in select" :key="index">{{ value }}
                        <i class="feather icon-x p-0.5 rounded-md hover:bg-blue-600" @click="deleteItem(value)"></i>
                    </span>
                </template>
                <span v-if="typeof this.select == 'string'" class="block px-4 py-1">{{ select }}</span>
            </div>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <i class="feather icon-chevron-down"></i>
            </span>
        </button>
    </span>

    <div v-show="boxShow" @mouseleave="boxShow = false" class="absolute mt-1 w-full rounded-md bg-white shadow-lg">
        <ul class="max-h-56 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
            <li
                class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9 h-10 hover:text-white hover:bg-blue-400"
                @click="selected"
                v-for="(item, index) in selectList"
                :key="index">
                <span class="block truncate absolute w-full h-full py-2 pl-3 pr-9 top-0 right-0 bg-transparent z-50">
                    {{ item }}
                </span>

                <span class="absolute inset-y-0 right-0 flex items-center pr-4">
                    <i class="feather icon-check-circle text-blue-900" v-show="check(item)"></i>
                    <input type="checkbox" class="form-checkbox hidden" :checked="check(item)" :value="item" />
                </span>
            </li>
            <!-- More options... -->
        </ul>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
export default {
    props: ["name"],
    data() {
        return {
            select: "select a " + this.name,
            boxShow: false
        };
    },
    computed: {
        ...mapGetters(["getDefaultData"]),
        selectList() {
            return this.$store.state.editProfile.languages;
        }
    },
    methods: {
        check(el) {
            if (typeof this.select == "object") {
                return this.select.find(item => {
                    return el == item;
                });
            }
        },
        selected(e) {
            typeof this.select == "string" ? (this.select = []) : "";
            let el = e.target.nextElementSibling.children[1].value;
            let icon = e.target.nextElementSibling.children[0];
            let input = e.target.nextElementSibling.children[1];

            if (!input.checked) {
                this.select.push(el);
            } else {
                this.select = this.select.filter(item => {
                    return item !== el;
                });
            }
            this.boxShow = false;
        },
        deleteItem(el) {
            let inputs = document.getElementsByClassName("form-checkbox");
            this.select = this.select.filter(item => {
                return item !== el;
            });
            if (this.select.length == 0) {
                this.select = "select a " + this.name;
            }
            this.boxShow = false;
        }
    },
    watch: {
        select() {
            if (this.select.length == 0) {
                this.select = "select a " + this.name;
            }
            this.$store.commit("setFormData", {
                name: this.name,
                data: this.select
            });
        }
    },
    mounted() {
        let defaultData = this.getDefaultData[this.name];
        if (defaultData && defaultData.length) {
            this.select = this.getDefaultData[this.name];
        }
    }
};
</script>

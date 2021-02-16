<template>
    <div>
        <input
            ref="input"
            :class="classList"
            :id="id"
            :name="name"
            :type="type"
            :required="required"
            :placeholder="placeholder"
            v-model="data"
            :disabled="disabled"
        />
        <p v-if="$page.props.errorBags[name]" class="text-xs text-red-600">
            {{ $page.props.errorBags[name] }} hugo
        </p>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    props: ['name', 'type', 'required', 'id', 'value', 'placeholder', 'disabled'],
    data() {
        return {
            data: '',
            classes:
                this.type === 'checkbox' || this.type === 'radio'
                    ? 'form-' + this.type
                    : 'appearance-none w-full rounded relative px-3 py-2 border font-medium border-gray-300 placeholder-gray-400 text-gray-700 border-4 focus:border-blue-200  focus:outline-none focus:shadow-md  focus:z-10 sm:text-sm sm:leading-5',
        };
    },
    computed: {
        ...mapGetters(['getDefaultData']),
        classList() {
            if (this.$page.props.errorBags[this.name]) {
                return this.classes + ' border-red-600';
            }
            return this.classes;
        },
    },
    watch: {
        data() {
            this.$store.commit('setFormData', {
                name: this.name,
                data: this.type === 'checkbox' || this.type === 'radio' ? [this.value] : this.data,
            });
        },
    },
    mounted() {
        switch (this.type) {
            case 'checkbox':
                if (this.getDefaultData[this.name]) {
                    this.getDefaultData[this.name].map(item => {
                        if (item == this.value) {
                            this.$refs.input.checked = true;
                        }
                    });
                }
                break;
            case 'radio':
                if (this.getDefaultData[this.name]) {
                    this.getDefaultData[this.name].map(item => {
                        if (item == this.value) {
                            this.$refs.input.checked = true;
                        }
                    });
                }
                break;
            default:
                this.data = !this.getDefaultData[this.name] ? '' : this.getDefaultData[this.name];
                break;
        }
    },
};
</script>

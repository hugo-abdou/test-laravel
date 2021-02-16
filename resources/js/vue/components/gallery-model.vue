<template>
    <transition
        enter-active-class="transition ease-out duration-200"
        enter-class="transform opacity-0"
        enter-to-class="transform opacity-100"
        leave-active-class="transition ease-in duration-75"
        leave-class="transform opacity-100"
        leave-to-class="transform opacity-0"
    >
        <div
            class="w-full bg-gray-900 bg-opacity-75  fixed h-full z-50 top-0"
            v-show="show"
            @mousewheel="slide"
        >
            <div class="relative w-full h-full ">
                <button class="absolute top-5 right-6 text-2xl text-white" @click="hideModel">
                    <i
                        class="feather icon-x"
                        style="text-shadow: 5px 2px 3px rgba(0, 0, 0, 0.1);"
                        data-close="true"
                    ></i>
                </button>
                <div
                    class="absolute top-5/12 left-1/12 bg-gray-800 bg-opacity-50 leading-none rounded-lg text-5xl text-white active:animate-ping"
                    @click="prevImg"
                    :class="{ 'text-gray-700': prevBtnDesabeld }"
                >
                    <i
                        class="feather icon-chevron-left"
                        style="text-shadow: 5px 2px 3px rgba(0, 0, 0, 0.1);"
                    ></i>
                </div>
                <div
                    class="absolute top-5/12 right-1/12 bg-gray-800 bg-opacity-50 leading-none rounded-lg text-5xl text-white active:animate-ping"
                    @click="nextImg"
                    :class="{ 'text-gray-700': nextBtnDesabeld }"
                >
                    <i
                        class="feather icon-chevron-right"
                        style="text-shadow: 5px 2px 3px rgba(0, 0, 0, 0.1);"
                    ></i>
                </div>
                <div
                    class="flex items-center h-10/12 justify-center"
                    @click="hideModel"
                    data-close="true"
                >
                    <img
                        v-if="selectedImage"
                        class="max-h-11/12 max-w-11/12 object-cover rounded-lg shadow"
                        :src="`/storage/${selectedImage.url}`"
                    />
                </div>
                <div class="absolute bottom-0 w-full h-2/12 py-1">
                    <div class="h-full w-full relative bg-gray-900 flex justify-center">
                        <ul
                            class="absolute flex items-center justify-start h-full space-x-3 transform duration-200 z-0"
                            @click="hideModel"
                            :style="{
                                left: '42%',
                                '--transform-translate-x': `-${position}px`,
                            }"
                        >
                            <li
                                class="rounded-lg shadow-sm overflow-hidden duration-100 transform hover:scale-105 cursor-pointer h-11/12"
                                v-for="(img, index) in getGallery.images"
                                :class="{
                                    'border-8 border-double border-gray-400 h-full':
                                        selectedImage.id == img.id,
                                }"
                                :key="img.id"
                            >
                                <div
                                    class="relative min-w-60 max-w-60 h-full"
                                    @click="selectImage(img, index)"
                                >
                                    <img
                                        :src="`/storage/${img.url}`"
                                        class="w-full h-full object-cover"
                                    />
                                    <div
                                        v-if="img.role"
                                        class="-rotate-45 -translate-x-7 absolute bg-teal-400 font-bold h-7 shadow-lg text-center text-gray-800 top-0 transform translate-y-4 w-28"
                                    >
                                        <span>{{ img.role }}</span>
                                    </div>

                                    <transition
                                        enter-active-class="transition ease-out duration-100"
                                        enter-class="transform opacity-0"
                                        enter-to-class="transform opacity-100"
                                        leave-active-class="transition ease-in duration-500"
                                        leave-class="transform opacity-100"
                                        leave-to-class="transform opacity-0"
                                    >
                                        <div
                                            v-if="selectedImage.id !== img.id"
                                            class="absolute w-full h-full top-0 bg-gray-900 bg-opacity-75"
                                        ></div>
                                    </transition>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            selectedImage: null,
            prevBtnDesabeld: false,
            nextBtnDesabeld: false,
            position: 0,
        };
    },
    computed: {
        ...mapGetters(['getGallery']),
        show() {
            if (this.getGallery.model.show) {
                this.getGallery.selectedImageIndex < this.getGallery.images.length - 1
                    ? (this.nextBtnDesabeld = false)
                    : (this.nextBtnDesabeld = true);
                this.getGallery.selectedImageIndex > 0
                    ? (this.prevBtnDesabeld = false)
                    : (this.prevBtnDesabeld = true);
                this.position = 252 * this.getGallery.selectedImageIndex;
                this.selectedImage = this.getGallery.images[this.getGallery.selectedImageIndex];
                return true;
            }
            this.$store.commit('restGalleryValus');
            return false;
        },
    },
    methods: {
        hideModel(e) {
            if (e.target.dataset.close) {
                this.$store.commit('hideGalleryModel');
            }
        },
        selectImage(img, index) {
            event.preventDefault();
            this.getGallery.selectedImageIndex = index;
        },
        prevImg() {
            if (!this.prevBtnDesabeld) {
                this.getGallery.selectedImageIndex = this.getGallery.selectedImageIndex - 1;
            }
        },
        nextImg() {
            if (!this.nextBtnDesabeld) {
                this.getGallery.selectedImageIndex = this.getGallery.selectedImageIndex + 1;
            }
        },
        slide(e) {
            e.preventDefault();
            let i = 0;
            if (e.wheelDelta > 0 && this.position < 255 * (this.getGallery.images.length - 2)) {
                this.position = this.position + 252;
                this.nextImg();
            }
            if (e.wheelDelta < 0 && this.position >= 252) {
                this.position = this.position - 252;
                this.prevImg();
            }
        },
    },
};
</script>

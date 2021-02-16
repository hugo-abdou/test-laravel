<template>
    <i v-bind="$attrs" class="feather" :class="`icon-${name}`"></i>
</template>

<script>
export default {
    props: ['name'],
};
</script>

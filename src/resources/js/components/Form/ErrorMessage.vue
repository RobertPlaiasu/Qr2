<template>
    <small v-if="error !== undefined" class="text-sm font-black text-red-600">
        * {{ error }}
    </small>
</template>

<script>
export default {
    props: ['error'],
}
</script>

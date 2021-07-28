<template>
    <div class="w-full focus:text-indigo-700 hover:text-indigo-700 justify-center inline-block text-center pt-2 pb-1">
        <inertia-link v-if="url !== undefined" :href="url">
            <slot name="icon"></slot>
            <span class="tab tab-home block text-xs"> {{ text }} </span>
        </inertia-link>
        <button v-else @click="clicked">
            <slot name="icon"></slot>
            <span class="tab tab-home block text-xs"> {{ text }} </span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['url', 'text'],

        methods: {
            clicked() {
                this.$emit('clicked', true);
            }
        }
    }
</script>

<template>
    <inertia-link 
        :href="uri" 
        :class="`cursor-pointer bg-transparent hover:bg-${color}-500 text-${color}-700 font-semibold hover:text-white py-1 px-4 m-2 border border-${color}-500 hover:border-transparent rounded`"
    >
        <slot />
    </inertia-link>
</template>

<script>
    export default {
        props: ['uri', 'color'],
    }
</script>
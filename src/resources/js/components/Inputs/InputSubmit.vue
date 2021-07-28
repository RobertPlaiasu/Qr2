<template>
    <input
        :disabled="loading"
        type="submit"
        value="Salvează"
        class="px-4 py-2 mt-8 font-bold text-white border rounded select-none bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-700 hover:to-indigo-500 "
    />
</template>

<script>
    export default {
        props: ['loading'],
    }
</script>

<style scoped>
    input:disabled {
        background: black;  
    }
</style>


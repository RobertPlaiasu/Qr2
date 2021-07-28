<template>
    <div class="flex items-center border-b border-indigo-700 py-2 pt-5 m-5">
        <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input 
            v-model="searchInput" 
            @change="search"
            type="text" 
            placeholder="Caută produs" 
            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
        >
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchInput: '',
            }
        },

        methods: {
            search() {
                this.$emit('search', this.searchInput);
            }
        }
    }
</script>

<template>
    <button 
        type="button"
        @click="$emit('click')"
        class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
    >
        <span class="flex items-center">
            <span class="block ml-3 truncate">
                <p v-for="(value, key) in selected" :key="key">
                    <span v-if="!key.includes('id')"> {{ value }} </span> 
                </p>
            </span>
        </span>

        <dropdown-icon />
    </button>
</template>

<script>
import DropdownIcon from '../Icons/DropdownArrows.vue';

export default {
    props: [ 'selected' ],
    components: { DropdownIcon }
}
</script>
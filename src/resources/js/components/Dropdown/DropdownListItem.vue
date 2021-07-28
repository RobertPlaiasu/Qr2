<template>
    <li 
        @click="$emit('click')"
        class="relative p-2 text-gray-900 cursor-pointer select-none hover:bg-purple-700 hover:text-white" 
    >
        <slot />
    </li>
</template>
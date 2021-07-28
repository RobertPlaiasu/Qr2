<template>
    <div class="w-full p-8 bg-white rounded shadow-lg sm:m-4 sm:w-3/4 md:w-auto">
        <h1 class="block w-full mb-6 text-lg font-bold text-center uppercase text-grey-darkest"> {{ title }} </h1>
        <slot />
    </div>
</template>
<script>
export default {
    props: [
        'title'
    ],
}
</script>
<style scoped>
    form
    {
        height: fit-content;
        width: 48rem;
    }
    @media (max-width: 639px)
    {
        form
        {
            height: auto!important;
        }
    }
</style>

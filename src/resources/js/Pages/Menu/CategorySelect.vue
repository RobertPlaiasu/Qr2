<template>
    <div class="h-screen">
        <div class="flex items-center justify-center bg-gradient-to-r from-indigo-900 to-indigo-600">
            <a :href="menuPath" class="text-white mr-auto m-4"><i class="fas fa-arrow-left"></i></a>
            <h1 class="text-white text-2xl uppercase font-black mr-auto"> {{ restaurantName  }} </h1>
        </div>
        <div class="flex items-center justify-center flex-col">
            <div v-for="category in categories" :key="category.id" class="border rounded-sm hover:border-indigo-600 border-black mx-4 my-2 w-full text-center">
                <a :href="menuPath + '?menu=category&category=' + category.id" class="uppercase text-xl hover:text-indigo-600">
                    {{ category.name }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'menuPath', 'categories', 'restaurantName', 'title' ],

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>
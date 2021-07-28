<template>
    <div class="h-screen">
        <div class="overflow-hidden bg-gradient-to-r from-indigo-900 to-indigo-600 h-screen">
            <div class="flex items-center justify-center">
                <a :href="menu + '?menu=category'" class="text-white mr-auto m-4"><i class="fas fa-arrow-left"></i></a>
                <h1 class="text-white text-2xl font-black mr-auto"> {{ restaurantName  }} </h1>
            </div>
            <div class="flex items-center justify-center h-full">
                <a :href="`${menuPath}?menu=category`">
                    <div class="uppercase bg-white rounded-full flex items-center justify-center m-4" style="width: 100px; height: 100px;"> 
                        Categorii
                    </div>
                </a>
                <a :href="`${menuPath}?menu=promo`">
                    <div class="uppercase bg-white rounded-full flex items-center justify-center m-4" style="width: 100px; height: 100px;"> 
                        Promoții
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'menuPath', 'restaurantName', 'title' ],

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>
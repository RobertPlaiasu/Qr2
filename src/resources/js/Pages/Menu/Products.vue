<template>
    <div class="h-screen">
        <div class="flex items-center justify-center bg-gradient-to-r from-indigo-900 to-indigo-600">
            <a :href="menuPath" class="text-white mr-auto m-4"><i class="fas fa-arrow-left"></i></a>
            <h1 class="text-white text-2xl uppercase font-black mr-auto"> {{ restaurantName  }} </h1>
        </div>
        <div class="flex items-center justify-center bg-gradient-to-r from-indigo-200 to-indigo-100">
            <h1 class="text-white text-2xl uppercase font-black"> {{ subtitle  }} </h1>
        </div>
        <div class="flex items-center justify-center flex-col">
            <div v-for="product in products" :key="product.id" class="border-b-2 border-gray-200 py-6 container flex flex-col items-center justify-center">
                <!-- Product Details -->
                <div class="flex w-full">
                    <!-- PICTURE -->
                    <img :src="productImage(product)" :alt="product.name" />

                    <!-- ATTRIBUTES -->
                    <div class="px-3 bg-white">
                        <div class="font-bold text-md mb">{{ product.name }}</div>
                        <p class="text-md">{{ product.ingredients }}</p>
                        <div :class="[ isUnavailable(product) ? 'text-red-700'  : 'text-green-700' ]" class="text-md font-bold">
                            Produs {{isUnavailable(product) ? 'in' : ''}}disponibil
                        </div>
                    </div>

                    <div class="ml-auto text-right">
                        <div class="text-md mb">{{ product.price }} lei</div>
                        <div class="text-md mb">{{ product.weight }}g</div>
                    </div>
        
                </div>
                <!-- Change Availability -->
                <button
                    v-if="canChangeAvailability"
                    @click="changeAvailability(product.id)"
                    class="text-center w-full p-4 text-md mb bg-indigo-600 text-white hover:bg-indigo-500"
                >
                    Schimba disponibilitatea
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'menuPath', 'products', 'restaurantName', 'title', 'canChangeAvailability', 'subtitle' ],

        methods: {
            productImage(product) {
                return product.picture ? '/../storage/' + product.picture : '/img/template.jpg';
            },

            isUnavailable(product) {
                return product.available === 0;
            },

            changeAvailability(product) {
                this.$inertia.post(`/products/${product}/change-availability`);
            }
        },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

<style>
    img {
        max-width: 150px;
        height: 150px;
        object-fit: cover;
    }
</style>
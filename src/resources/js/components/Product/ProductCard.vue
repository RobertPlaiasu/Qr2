<template>
    <div>
        <!-- IMAGE -->
        <img 
            v-bind:class="[ isUnavailable(product) ? 'unavailable' : '', 'w-full']" 
            :src="productImage(product)" 
            :alt="product.name"
            style="max-height: 200px;" 
        />
        
        <!-- ATTRIBUTES -->
        <div class="px-6 py-4 bg-white">
            <div class="font-bold text-xl mb">{{ product.name }}</div>
            <div class="font-bold text-md mb-1">{{ product.weight }}g | {{ product.price }} RON</div>
            <p class="text-gray-700 text-base">{{ product.ingredients }}</p>
        </div>

        <!-- AVAILABILITY IDICATOR -->
        <div class="absolute bottom-0 card">
            <div :class="[ isUnavailable(product) ? 'bg-red-700'  : 'bg-green-700' ]" class="text-center w-full p-4 text-md mb text-white">
                Produs {{isUnavailable(product) ? 'in' : ''}}disponibil
            </div>

            <!-- CHANGE AVAILABILITY -->
            <button
                v-if="canChangeAvailability"
                @click="changeAvailability(product.id)"
                class="text-center w-full p-4 text-md mb bg-indigo-700 text-white hover:bg-indigo-500"
            >
                Schimba disponibilitatea
            </button>

            <!-- EDIT PRODUCT -->
            <div
                v-if="isAdmin"
                :href="`products/${product.id}/edit`"
                class="text-center w-full p-4 text-md mb bg-orange-500 text-white hover:bg-orange-300 cursor-pointer"
            >
                <inertia-link :href="`/products/${product.id}/edit`" class="w-full"> Editează produsul </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product', 'canChangeAvailability', 'isAdmin'],

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
        }
    }
</script>
<style scoped>
    .unavailable
    {
        filter: grayscale(100%);
    }

    .card
    {
        width: -webkit-fill-available;
        width: -moz-available;
    }
</style>

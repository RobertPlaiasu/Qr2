<template>
    <div>
        <h1 class="font-sans font-bold text-3xl px-5"> Produse - {{ category.name }} </h1>

        <!-- NO PRODUCTS INSIDE A CATEGORY -->
        <div 
            v-if="filteredProducts == 0 && search == ''"
            class="text-center m-8 text-red-500 font-bold" 
        > 
            Nu avem produse în acestă categorie! 
        </div>

        <!-- NO PRODUCTS RETURNED FROM THE SEARCH -->
        <div 
            v-else-if="filteredProducts == 0 && search != ''"
            class="text-center m-8 text-red-500 font-bold" 
        > 
            Nu avem niciun produs care să conțină - {{ search }}.
        </div>

        <!-- DISPLAY THE PRODUCTS -->
        <div class="showcase mb-24">
            <!-- CREATE PRODUCT BUTTON -->
            <inertia-link 
                v-if="isAdmin"
                :href="`/categories/${category.id}/products/create`" 
                class="px-6 py-4 bg-white hover:bg-indigo-700 transition duration-500 bg-white card-body border-2 border-indigo-700 max-w-xs rounded overflow-hidden shadow-lg m-3 flex justify-center items-center text-indigo-700 hover:text-white"
                style="width: -webkit-fill-available;"
            >
                <div class="p-4  card-text font-bold"> Creează produs </div>
            </inertia-link>

            <!-- ALL PRODUCTS -->
            <div 
                :key="product.id"
                v-for="product in filteredProducts" 
                class="max-w-xs rounded overflow-hidden shadow-lg m-3 relative bg-white" 
                style="height:30em" 
            >
                <product-card :product="product" :canChangeAvailability="canChangeAvailability" :isAdmin="isAdmin" />
            </div>
        </div>
    </div>
</template>

<script>
    import ProductCard from './ProductCard.vue';

    export default {
        props: [
            'category',
            'categoryIndex',
            'search',
            'products',
            'isAdmin',
            'canChangeAvailability'
        ],
        components: { ProductCard },

        computed: {
            filteredProducts( products ) {
                let productList = this.products[ this.categoryIndex ];
                return productList.filter(product => { 
                    return product.name.toLowerCase().includes(this.search.toLowerCase()); 
                });
            },
        }
    }
</script>

<style scoped>
    .showcase
    {
        overflow-x: auto;
        width: -webkit-fill-available;
        display: -webkit-inline-box;
        margin-right: 1em;
    }
</style>

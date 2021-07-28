<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
                    {{ menu.name }} - {{ category.name }} 
                </h2>

                <div class="hidden sm:block">
                    <custom-link color="indigo" :uri="`/categories/${category.id}/products/create`">
                        Adăugare produs
                    </custom-link>
                    <custom-link color="indigo" :uri="menu.uri"> 
                        Către meniu
                    </custom-link>
                </div>

                <div class="flex items-center -mr-2 sm:hidden">
                    <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="w-full lg:hidden">
                <div class="flex flex-col pt-4 pb-1 border-t border-gray-200">
                    <custom-link color="indigo" :uri="`/categories/${category.id}/products/create`">
                        Adăugare produs
                    </custom-link>
                    <custom-link color="indigo" :uri="`/menus/${menu.id}`"> 
                        Către meniu 
                    </custom-link>
                </div>
            </div>
        </template>
        <div class="flex justify-around p-8">
            <custom-table :items="generateProductTable" :uris="generateProductTableUris" class="w-full" />
        </div>
    </app-layout>
</template>

<script>
    import CustomTable from '../../components/Table/CustomTable.vue';
    import CustomLink from '../../components/Table/CustomLink.vue';
    import AppLayout from '../../Layouts/AppLayout.vue';

    export default {
        props: ['currentUser', 'category', 'products', 'menu', 'title'],
        components: { CustomTable, CustomLink, AppLayout },

        data: function () {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            deleteCategory(target) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acestă categorie?')) {
                    this.$inertia.delete( target );
                }
            }
        },

        computed: {
            generateProductTable() {
                return this.products.map(product => {
                    return {
                        ID: product.id,
                        Nume: product.name
                    };
                })
            },

            generateProductTableUris() {
                return this.products.map(product => {
                    return `/products/${product.id}`;
                })
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

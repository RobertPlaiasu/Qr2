<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
                    Lista restaurante 
                </h2>
            </div>
        </template>

        <div class="flex justify-around p-8">
            <custom-table :items="generateRestaurants" :uris="uris" :hasEdit="true" :hasShow="true" class="w-full"/>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue';

    export default {
        props: ['currentUser', 'restaurants', 'uris', 'menus', 'title'],
        components: { AppLayout, CustomTable },

        computed: {
            generateRestaurants() {
                return this.restaurants.map(restaurant => {
                    return {
                        ID: restaurant.id,
                        Nume: restaurant.name,
                        Oraș: restaurant.location
                    };
                });
            },
        },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> Lista orașe </h2>
                <custom-link color="indigo" :uri="`cities/create`"> Adăugare oraș </custom-link>
            </div>
        </template>

        <div class="flex justify-around p-8">
            <custom-table :items="generateCities" :uris="generateUris" :hasEdit="true" :hasShow="true" class="w-full"></custom-table>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue';
    import CustomLink from '../../components/Table/CustomLink.vue';

    export default {
        props: ['items', 'currentUser', 'counties', 'title'],
        components: { AppLayout, CustomTable, CustomLink },

        computed: {
            generateCities() {
                return this.items.map((city, index) => {
                    return {
                        ID: city.id,
                        Nume: city.name,
                        Judet: this.counties[index],
                    };
                });
            },

            generateUris() {
                return this.items.map(city => {
                    return `cities/${city.id}`;
                } );
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

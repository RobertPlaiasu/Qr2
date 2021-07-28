<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> Lista județe </h2>
                <custom-link color="indigo" :uri="`counties/create`"> Adăugare județ </custom-link>
            </div>
        </template>

        <div class="flex justify-around p-8">
            <custom-table :items="generateCounties" :uris="generateUris" :hasEdit="true" :hasShow="true" class="w-full"></custom-table>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue';
    import CustomLink from '../../components/Table/CustomLink.vue';

    export default {
        props: ['currentUser', 'counties', 'title'],
        components: { AppLayout, CustomTable, CustomLink },

        computed: {
            generateCounties()
            {
                return this.counties.map((county, index) => {
                    return {
                        ID: county.id,
                        Nume: county.name,
                    };
                });
            },

            generateUris() {
                return this.counties.map(county => {
                    return `counties/${county.id}`;
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

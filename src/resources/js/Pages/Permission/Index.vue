<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> Lista permisiuni </h2>
                <custom-link color="indigo" :uri="`permissions/create`"> Adăugare permisiune </custom-link>
            </div>
        </template>

        <div class="flex justify-around p-8">
            <custom-table :items="generatePermissions" :uris="generateUris" :hasEdit="true" :hasShow="true" class="w-full"></custom-table>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue';
    import CustomLink from '../../components/Table/CustomLink.vue';

    export default {
        props: ['permissions', 'currentUser', 'title'],
        components: { AppLayout, CustomTable, CustomLink },

        computed: {
            generatePermissions() {
                return this.permissions.map((permission, index) => {
                    return {
                        ID: permission.id,
                        Nume: permission.name,
                        Descriere: permission.description,
                    };
                });
            },

            generateUris() {
                return this.permissions.map(permission => {
                    return `permissions/${permission.id}`;
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

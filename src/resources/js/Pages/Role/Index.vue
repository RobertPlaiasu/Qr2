<template>
    <app-layout :user="user">
        <template #header>
            <div class="flex w-full flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Lista roluri
                </h2>
                <inertia-link class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded" href="/roles/create"> Crează </inertia-link>
            </div>
        </template>

        <div class="lg:w-9/12 mx-auto">
            <custom-table :items="generateRoles" :uris="generateUris" :hasEdit="true" :hasShow="true"></custom-table>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue'

    export default {
        props: ['roles', 'user', 'title'],
        components: { AppLayout, CustomTable },

        methods: {
            generateRole(role) {
                return {
                    ID: role.id,
                    Nume: role.name,
                    Descriere: role.description,
                }
            },

            generateUri(role) {
                return `roles/${role.id}`;
            }
        },

        computed: {
            generateRoles() {
                return this.roles.map( this.generateRole );
            },

            generateUris() {
                return this.roles.map( this.generateUri );
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

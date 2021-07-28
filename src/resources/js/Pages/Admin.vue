<template>
    <app-layout :user="user">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
                    Admin Dashboard 
                </h2>
            </div>
        </template>

        <!-- <div class="max-w-xl"> -->
            <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 lg:grid-cols-4 gap-12 p-8 max-w-7xl mx-auto">
                <inertia-link v-for="panel in panels" :key="panel.url" :href="`/${panel.url}`" class="shadow-md rounded-lg p-24 border-b-4 border-indigo-700 flex justify-center uppercase bg-white hover:font-bold hover:text-white hover:bg-indigo-700">{{ panel.name }}</inertia-link>
            </div>
        <!-- </div> -->
    </app-layout>
</template>

<script>
    import AppLayout from '../Layouts/AppLayout.vue';

    export default {
        props: ['user', 'title'],
        components: { AppLayout },

        data() {
            return {
                panels: [
                    {
                        name: 'Restaurante',
                        url: 'restaurants',
                    },
                    {
                        name: 'Meniuri',
                        url: 'menus',
                    },
                    {
                        name: 'Orașe',
                        url: 'cities',
                    },
                    {
                        name: 'Județe',
                        url: 'counties',
                    },
                    {
                        name: 'Roluri',
                        url: 'roles',
                    },
                    {
                        name: 'Creaază restaurant owner',
                        url: 'assign_roles/create',
                    },
                ],
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

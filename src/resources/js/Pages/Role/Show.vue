<template>
    <app-layout :user="this.user">
        <template #header>
           <div class="flex w-full justify-between items-center flex-col">

                <!-- Primary Navigation Menu -->
                <div class="flex w-full flex-row justify-between items-center">

                    <!-- Role Name -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ role.name }}
                    </h2>

                    <!-- Navigation Links -->
                    <div class="hidden md:block justify-end">
                        <inertia-link :href="`/roles/${role.id}/edit`" class="m-1 bg-indigo-600 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded">
                            Editează rolul
                        </inertia-link>
                        <button @click="deleteRole(`/roles/${role.id}`)" class="m-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                            Șterge
                        </button>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="md:hidden w-full">
                    <div class="pt-4 pb-1 border-t border-gray-200 flex flex-col">
                        <inertia-link :href="`/roles/${role.id}/edit`" class="m-1 bg-indigo-600 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded" v-if="menu !== null">
                            Editează rolul
                        </inertia-link>
                        <button @click="deleteRole(`/roles/${role.id}`)" class="m-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                            Șterge
                        </button>
                    </div>
                </div>
           </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <!-- Main Card -->
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <section-title>
                            <template #title>
                                {{ role.name }}
                            </template>
                            <template #description>
                                <p> {{ role.description }} </p>
                                <p> Persoanele cu acest rol pot: </p>
                                <ul class="list-disc list-inside">
                                    <li v-for="permission in permissions" :key="permission.id" class="ml-2">
                                        {{ permission.description  }}
                                    </li>
                                </ul>
                            </template>
                        </section-title>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import SectionTitle from '../../Jetstream/SectionTitle'

    export default {
        props: [
            'role',
            'permissions',
            'user',
            'errors',
            'title'
        ],

        components: {
            AppLayout,
            SectionTitle
        },

        data: function ()
        {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            deleteRole ( target ) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acest rol?')) {
                    this.$inertia.delete( target )
                    .then(() => {
                    })
                }
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

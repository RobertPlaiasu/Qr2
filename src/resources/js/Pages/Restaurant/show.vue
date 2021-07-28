<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-col items-center justify-between w-full">

                <!-- Primary Navigation Menu -->
                <div class="flex flex-row items-center justify-between w-full">

                    <!-- Restaurant Name && Andress -->
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ restaurant.name }} - {{ restaurant.location }}, {{ city }}
                    </h2>

                    <!-- Navigation Links -->
                    <div class="justify-end hidden lg:block">
                        <inertia-link :href="`${menu}`" v-if="menu !== null" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400">
                            Meniu
                        </inertia-link>

                        <inertia-link :href="`${menu}/categories`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu !== null && isAdmin">
                            Categorii
                        </inertia-link>

                        <inertia-link :href="`${menu}/promos`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu !== null && isAdmin">
                            Promotii
                        </inertia-link>

                        <inertia-link v-if="isAdmin" :href="`/staff${restaurant.uri}`" class="px-4 py-2 m-1 font-bold text-white bg-blue-600 rounded hover:bg-blue-400">
                            Angajați
                        </inertia-link>

                        <inertia-link v-if="isAdmin" :href="edit" class="px-4 py-2 m-1 font-semibold text-indigo-600 bg-transparent border border-indigo-600 rounded hover:bg-indigo-600 hover:text-white hover:border-transparent">
                            Editează restaurantul
                        </inertia-link>

                        <a :href="`${menu}/download`" class="m-1" v-if="menu !== null && isAdmin">
                            <button class="inline-flex items-center px-4 py-2 font-bold text-gray-800 bg-gray-100 rounded shadow hover:bg-gray-200">
                                <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                                <span>Descarcă QrCode</span>
                            </button>
                        </a>

                        <inertia-link @click="resign()" class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded hover:bg-red-400 cursor-pointer" v-if="employeeRelation">
                            Demisionează
                        </inertia-link>

                        <button @click="deleteRestaurant(restaurant.uri)" class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded shadow hover:bg-red-700" v-if="isAdmin">
                            Șterge
                        </button>
                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center -mr-2 lg:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="w-full lg:hidden">
                    <div class="flex flex-col pt-4 pb-1 border-t border-gray-200">
                        <inertia-link :href="`${menu}`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu !== null">
                            Meniu
                        </inertia-link>

                        <inertia-link :href="`${menu}/categories`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu !== null && isAdmin">
                            Categorii
                        </inertia-link>

                        <inertia-link :href="`${menu}/promos`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu !== null && isAdmin">
                            Promotii
                        </inertia-link>

                        <inertia-link :href="`/staff${restaurant.uri}`" class="px-4 py-2 m-1 font-bold text-white bg-blue-600 rounded hover:bg-blue-400" v-if="isAdmin">
                            Angajați
                        </inertia-link>

                        <inertia-link :href="edit" class="px-4 py-2 m-1 font-semibold text-indigo-600 bg-transparent border border-indigo-600 rounded hover:bg-indigo-600 hover:text-white hover:border-transparent" v-if="isAdmin">
                            Editează restaurantul
                        </inertia-link>

                        <a :href="`${menu}/download`" class="inline-flex items-center px-4 py-2 m-1 font-bold text-gray-800 bg-gray-100 rounded shadow hover:bg-gray-200" v-if="menu !== null && isAdmin">
                            <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                            <span>Descarcă QrCode</span>
                        </a>

                        <inertia-link @click="resign()" class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded hover:bg-red-400 cursor-pointer" v-if="employeeRelation">
                            Demisionează
                        </inertia-link>

                        <button @click="deleteRestaurant(restaurant.uri)" class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded shadow hover:bg-red-700" v-if="isAdmin">
                            Șterge
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">

                    <!-- Main Card -->
                    <img :src="restaurantImage()" :alt="restaurant.name" class="w-full"/>
                    <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                        <section-title>
                            <template #title>
                                Bun venit la {{ restaurant.name }}
                            </template>
                            <template #description>
                                {{ restaurant.description }}
                            </template>
                        </section-title>
                        <div class="flex flex-col mt-5 text-center sm:mt-8 sm:justify-start sm:flex-row lg:justify-start">
                            <inertia-link :href="`${menu}`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-if="menu">
                                Meniu
                            </inertia-link>
                            <inertia-link :href="`${restaurant.uri}/menus/create`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400" v-else-if="isAdmin">
                                Crează meniu
                            </inertia-link>
                            <inertia-link :href="edit" class="px-4 py-2 m-1 font-semibold text-indigo-600 bg-transparent border border-indigo-600 rounded hover:bg-indigo-600 hover:text-white hover:border-transparent" v-if="isAdmin">
                                Editează restaurantul
                            </inertia-link>
                            <button @click="deleteRestaurant(restaurant.uri)" class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded shadow hover:bg-red-700" v-if="isAdmin">
                                Șterge
                            </button>
                        </div>
                    </div>

                    <!-- Advertise Card -->
                    <Advertise />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import Advertise from '../../components/Advertise.vue'
    import AppLayout from '../../Layouts/AppLayout.vue'
    import SectionTitle from '../../Jetstream/SectionTitle.vue'
    import Button from '../../Jetstream/Button.vue'

    export default {
        components: { AppLayout, SectionTitle, Button, Advertise },
        props: [
            'user',
            'restaurant',
            'menu',
            'currentUser',
            'download',
            'city',
            'edit',
            'isAdmin',
            'employeeRelation',
            'title'
        ],

        data: function () {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            deleteRestaurant(target) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acest restaurant?')) {
                    this.$inertia.delete(target)
                    .then(() => {
                    })
                }
            },

            restaurantImage() {
                return this.restaurant.picture ? '/../storage/' + this.restaurant.picture : '/img/template.jpg';
            },

            resign() {
                this.$inertia.delete(`/assign_roles${this.restaurant.uri}/${this.employeeRelation.id}`)
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

<style scoped>
    .tooltip .tooltip-text
    {
        display: none;
        position: absolute;
        margin-top: 1em;
    }

    .tooltip:hover .tooltip-text
    {
        display: block;
    }
</style>

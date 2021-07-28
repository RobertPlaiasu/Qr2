<template>
    <app-layout :user="user">
        <template #header>
            <div class="flex flex-col items-center justify-between w-full">
                <div class="flex flex-row items-center justify-between w-full">
                    <!-- Title -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ restaurant.name }} - angajați
                    </h2>

                    <!-- Nav Links -->
                    <div class="justify-end hidden sm:block flex flex-row" v-if="isAdmin">
                        <inertia-link :href="`${restaurant.uri}/invitations/create`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400"> Angajează </inertia-link>
                        <inertia-link class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded hover:bg-red-400 cursor-pointer" @click="toggleEmployeeSelection('delete')"> Concediază </inertia-link>
                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center -mr-2 sm:hidden">
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
                        <inertia-link :href="`/restaurants/${restaurant.id}/invitations/create`" class="px-4 py-2 m-1 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-400"> Angajează </inertia-link>
                        <inertia-link class="px-4 py-2 m-1 font-bold text-white bg-red-600 rounded hover:bg-red-400 cursor-pointer" @click="toggleEmployeeSelection('delete')"> Concediază </inertia-link>
                    </div>
                </div>
            </div>
        </template>
        <div class="py-12 flex flex-col lg:flex-row justify-around max-w-7xl mx-auto sm:px-6 lg:px-8">
            <custom-table :items="generateEmployeeTable"></custom-table>

            <custom-table :items="generateRoleTable"></custom-table>
        </div>

        <!-- Delete Form -->
        <div class="absolute inset-0 bg-black bg-opacity-50" v-if="userSelection">
            <div class="flex h-screen items-center justify-center">
                <div class="bg-white">
                    <div class="px-6 pt-6 pb-4 bg-indigo-700 text-white font-bold">
                        <h1>Alege angajatul</h1>
                    </div>

                    <div class="m-8">
                        <custom-select
                            :items="possibleUserRestaurants"
                            :selected="selectedUserRestaurant"
                            @selected="selectUserRestaurant"
                        ></custom-select>
                    </div>

                    <!-- Send Button -->
                    <div class="m-8 flex justify-center">
                        <div v-if="selectedUserRestaurant.id !== -1">
                            <div v-if="action === 'edit'"><custom-link :uri="actionUri" color="indigo"> Trimite </custom-link></div>
                            <div v-else-if="action === 'delete'" @click="deleteItem(actionUri)"><custom-link color="indigo"> Trimite </custom-link></div>
                        </div>
                        <div @click="userSelection = false"><custom-link color="red"> Închide </custom-link></div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../Layouts/AppLayout.vue'
    import CustomTable from '../components/Table/CustomTable.vue'
    import CustomLink from '../components/Table/CustomLink.vue';
    import CustomSelect from '../components/CustomSelect.vue';

    export default {
        props: [
            'userRestaurants',
            'user',
            'restaurant',
            'roles',
            'isAdmin',
            'invitations',
            'title'
        ],
        components: { AppLayout, CustomTable, CustomLink, CustomSelect },

        data: function () {
            return {
                showingNavigationDropdown: false,
                userDropdown: false,
                userSelection: false,
                user_email: '',
                selectedUserRestaurant: {
                    id: -1,
                    username: 'Nu ați ales niciun angajat',
                    role: '',
                },
                action: '',
            }
        },

        methods: {
            selectUserRestaurant(userRestaurant) {
                this.selectedUserRestaurant = userRestaurant;
                this.userDropdown = false;
            },

            toggleEmployeeSelection(targetAction) {
                this.action = targetAction;
                this.userSelection = true;
            },

            getUniqueValues(array) {
                let unique = [];

                for(let i = 0; i < array.length; ++i) {
                    let ok = true;
                    for(let j = 0; j < unique.length; j++) {
                        const element = array[i].id;
                        if(element === unique[j].id) {
                            ok = false;
                            break;
                        }
                    }
                    if(ok) unique.push(array[i]);
                }

                return unique;
            },

            deleteItem(targetUri) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acest obiect?'))
                    this.$inertia.delete( targetUri ) .then(() => {});
            }
        },

        computed: {
            generateEmployeeTable() {
                return this.userRestaurants.map( userRestaurant => {
                    return {
                        Angajat: userRestaurant.user.name,
                        Rol: userRestaurant.role.name,
                        Status: "Angajat"
                    }
                }).concat( this.invitations.map( invitation => {
                    return {
                        Angajat: invitation.email,
                        Role: invitation.role,
                        Status: "Invitat"
                    }
                }));
            },

            generateRoleTable() {
                let usableRoles = this.getUniqueValues( this.roles );

                return usableRoles.map((role) => {
                    return {
                        Roluri: role.name
                    };
                })
            },

            possibleUserRestaurants() {
                return this.userRestaurants.map(userRestaurant => {
                    return {
                        id: userRestaurant.id,
                        name: userRestaurant.user.name,
                        email: userRestaurant.user.email,
                        role: userRestaurant.role.name
                    };
                });
            },

            actionUri() {
                return `/assign_roles${this.restaurant.uri}/${this.selectedUserRestaurant.id}`;
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

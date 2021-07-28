<template>
    <app-layout :user="this.currentUser">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editare atribute angajat
            </h2>
        </template>

        <div class="py-12">
            <div v-if="Object.keys(errors).length > 0">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert" v-for="prop in Object.keys(errors)" v-bind:key="prop">
                    <p class="font-bold">Eroare</p>
                    <p>{{ errors[prop] }}</p>
                </div>
            </div>
            <form action="#" method="PATCH" class="mx-auto max-w-xl m-4 p-10 bg-white rounded shadow-xl" @submit.prevent="editUserRestaurant">
                <div class="mt-3">
                    <label class="block text-sm">Angajatul Selectat</label>

                    <button type="button" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label" class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <span class="flex items-center">
                            <span class="ml-3 block truncate">
                                {{ user.name }}, {{ user.email }}
                            </span>
                        </span>
                    </button>
                </div>

                <div class="mt-3">
                    <label class="block text-sm">Atribute actuale</label>

                    <custom-select
                        :items="filteredRoles"
                        :selected="getSelectedRole"
                        @selected="setSelectedRole"
                    />
                </div>

                <input class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 border rounded mt-8" type="submit" :disabled="loading" value="Adaugă">
                <input class="bg-red-700 hover:bg-red-500 text-white font-bold py-2 px-4 border rounded mt-8" type="button" @click="deleteUserRestaurant" :disabled="loading" value="Șterge atribuit">
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue'
    import CustomSelect from '../../components/CustomSelect.vue'

    export default {
        props: [ 
            'availableRoles', 
            'currentRoles', 
            'userRestaurant', 
            'user', 
            'authUser', 
            'restaurant', 
            'menu', 
            'errors' 
        ],
        components: { AppLayout, CustomSelect },

        data() {
            return {
                loading: false,
                userDropdown: false,
                form: {
                    user_id: this.user.id,
                    role_id: this.userRestaurant.role_id,
                    restaurant_id: this.restaurant
                },
                currentUser: {
                    username: this.authUser.name,
                    restaurant: `restaurants/${this.restaurant}`,
                    menu: this.menu
                }
            }
        },

        methods: {
            editUserRestaurant() {
                this.loading = true;
                this.$inertia.put(`/assign_roles/restaurants/${this.restaurant}/${this.userRestaurant.id}`, this.form)
                    .then(() => {
                        this.loading = false;
                    })
            },

            deleteUserRestaurant() {
                this.loading = true;
                if (confirm(`Sunteți sigur(ă) că doriți să stergeți acest atribut pentru ${this.user.name}?`))
                    this.$inertia.delete(`/assign_roles/restaurants/${this.restaurant}/${this.userRestaurant.id}`) .then(() => {});
            },

            isSelected(role) { 
                return this.form.role_id === role.id; 
            },

            setSelectedRole(role) {
                this.form.role_id = role.id;
            }
        },

        computed: {
            filteredRoles() {
                return this.availableRoles.map( role => { 
                    return {
                        id: role.id,
                        name: role.name,
                    }
                });
            },

            getSelectedRole() {
                return this.filteredRoles.filter( role => {
                    return this.isSelected(role);
                })[0];
            }
        }
    }
</script>

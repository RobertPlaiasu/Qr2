<template>
    <app-layout :user="currentUser">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
                Creare invitație - {{ restaurant.name }} 
            </h2>
        </template>
        <div class="flex flex-col justify-around pt-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div v-if="Object.keys(errors).length > 0">
                <div 
                    role="alert" 
                    v-for="prop in Object.keys(errors)" 
                    v-bind:key="prop"
                    class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500" 
                >
                    <p class="font-bold">Eroare</p>
                    <p>{{ errors[prop] }}</p>
                </div>
            </div>
            <form action="#" method="PATCH" @submit.prevent="createInvitation" class="max-w-xl p-10 m-4 mx-auto bg-white rounded shadow-xl">
                <div class="mt-3">
                    <span class="text-gray-700">Email anagajat</span>
                    <input class="block w-full mt-1 form-input" v-model="form.email" placeholder="angajat@gmail.com">
                </div>

                <div class="mt-3">
                    <span class="text-gray-700">Rol</span>
                    <custom-select
                        :items="filteredRoles"
                        :selected="getSelectedRole"
                        @selected="selectRole"
                    />
                </div>

                <input class="px-4 py-2 mt-8 font-bold text-white bg-indigo-700 border rounded hover:bg-indigo-500 border-gr8eb-700" type="submit" value="Trimite cerere">
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomSelect from '../../components/CustomSelect.vue';

    export default {
        props: ['errors', 'currentUser', 'restaurant', 'roles', 'title'],
        components: { AppLayout, CustomSelect },

        data: function () {
            return {
                form: {
                    'restaurant_id': this.restaurant.id,
                    'role_id': '',
                    'email': '',
                }
            }
        },

        methods: {
            createInvitation() {
                this.$inertia.post(`${this.restaurant.uri}/invitations`, this.form);
            },

            selectRole(role) {
                this.form.role_id = role.id;
            },

            isRoleSelected(role) {
                return role.id === this.form.role_id;
            },
        },

        computed: {
            filteredRoles() {
                return this.roles.map( role => {
                    return {
                        id: role.id,
                        name: role.name,
                    }
                });
            },

            getSelectedRole() {
                return this.filteredRoles.filter( role => {
                    return this.isRoleSelected(role);
                })[0] || {
                    id: '-1',
                    name: 'Niciun atribut ales'
                };
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

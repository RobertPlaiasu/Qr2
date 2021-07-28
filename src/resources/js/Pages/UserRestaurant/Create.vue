<template>
    <app-layout :user="user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adaugare prorietar
            </h2>
        </template>

        <div class="py-12">
            <div v-if="Object.keys(errors).length > 0">
                <div role="alert" v-for="prop in Object.keys(errors)" v-bind:key="prop" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <p class="font-bold">Eroare</p>
                    <p>{{ errors[prop] }}</p>
                </div>
            </div>
            <form action="#" method="PATCH" @submit.prevent="createUserRestaurant" class="mx-auto max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                <div class="mt-3">
                    <label class="block text-sm" for="user_email">Alegeti utilizator</label>
                    <small class="color-red font-xs mb-2">*Viitorul proprietar trebuie sa aiba deja cont pe platforma noastra</small>

                    <custom-select
                        :items="possibleUsers"
                        :selected="user_selected"
                        :hasSearch="true"
                        @selected="selectUser"
                    />
                </div>

                <input class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 border border-gr8eb-700 rounded mt-4" type="submit" :disabled="loading" value="Adaugă">
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue'
    import CustomSelect from '../../components/CustomSelect.vue'

    export default {
        props: ['role_id', 'user', 'users', 'title', 'errors'],
        components: { AppLayout, CustomSelect },

        data() {
            return {
                loading: false,
                userDropdown: false,
                user_selected: {
                    id: -1,
                    name: 'Niciun utilizator ales',
                    email: ' ',
                },
                form: {
                    user_id: '',
                    role_id: this.role_id,
                },
            }
        },

        methods: {
            createUserRestaurant() {
                this.loading = true;
                this.$inertia.post(`/assign_roles/`, this.form)
                    .then(() => {
                        this.loading = false;
                    })
            },

            selectUser(user) {
                this.user_selected = user;
                this.form.user_id = user.id;
                this.userDropdown = !this.userDropdown;
            },
        },

        computed: {
            possibleUsers() {
                let possibleUsers = this.users
                    .map(user => {
                        return {
                            id: user.id,
                            name: user.name,
                            email: user.email
                        }
                    })
                return possibleUsers;
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

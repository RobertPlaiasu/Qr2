<template>
    <app-layout :user="user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adaugare rol
            </h2>
        </template>

        <div class="py-12">
            <div v-if="Object.keys(errors).length > 0">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert" v-for="prop in Object.keys(errors)" v-bind:key="prop">
                    <p class="font-bold">Eroare</p>
                    <p>{{ errors[prop] }}</p>
                </div>
            </div>
            <form action="#" method="PATCH" class="mx-auto max-w-xl m-4 p-10 bg-white rounded shadow-xl" @submit.prevent="createRole">
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="name">Nume</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" v-model="form.name" type="text" required="" placeholder="Denumirea rolului" aria-label="Name">
                </div>

                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="description">Descriere</label>
                    <input class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" v-model="form.description" type="text" required="" placeholder="Descrierea rolului" aria-label="Description">
                </div>

                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="description">Permisiuni</label>
                    <select class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" v-model="form.permissions" required="" multiple>
                        <option v-for="permission in permissions" :key="permission.id" :value="permission.id"> {{ permission.name }} </option>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="inline-flex items-center mt-3">
                        <input type="checkbox" name="for_admin" class="form-checkbox h-5 w-5 text-gray-600" value="true" v-model="form.for_admin" checked><span class="ml-2 text-gray-700">Rol care poate fi atribuit doar de admin</span>
                    </label>
                </div>

                <input class="bg-indigo-700 hover:bg-indigo-500 text-white font-bold py-2 px-4 border border-gr8eb-700 rounded mt-8" type="submit" :disabled="loading" value="Adaugă">
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'

    export default {
        props: [ 'permissions',
            'user',
            'errors',
            'title'
        ],

        components: {
            AppLayout,
        },

        data: function ()
        {
            return {
                loading: false,

                form: {
                    name: '',
                    description: '',
                    permissions: [],
                },
            }
        },

        methods: {
            createRole() {
                this.loading = true;
                this.$inertia.post(`/roles`, this.form)
                    .then(() => {
                        this.loading = false;
                    })
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

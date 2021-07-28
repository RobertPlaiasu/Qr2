<template>
    <AuthCard>
        <form @submit.prevent="submit">
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">
                    Nume:
                </label>
                <input v-model="form.name" id="name" type="text" name="name" required
                       class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow">
                <div v-if="errors.name" class="text-red-700">{{ errors.name[0] }}</div>
            </div>

            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">
                    Email:
                </label>
                <input v-model="form.email" id="email" type="email" name="email" required
                       class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow">
                <div v-if="errors.email" class="text-red-700">{{ errors.email[0] }}</div>
            </div>

            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">
                    Parola:
                </label>

                <input v-model="form.password" id="password"
                       class="âw-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow"
                       type="password" name="password" required autocomplete="current-password"/>
            </div>

            <div class="mt-2">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
                    Confirmă parola:
                </label>

                <input v-model="form.password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow"
                       type="password" name="password_confirmation" required autocomplete="current-password"/>
                <div v-if="errors.password" class="text-red-700">{{ errors.password[0] }}</div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Register
                </button>
            </div>

            <div class="mt-4 border-t-2 text-center">
                <div class="p-2">
                    Ai deja un cont?
                    <inertia-link href="/login" class="underline">
                        Autentifică-te aici.
                    </inertia-link>
                </div>
            </div>

        </form>
    </AuthCard>
</template>

<script>

import Layout from '../../Components/Layout'
import AuthCard from "../../Components/AuthCard";

export default {
    components: {
        AuthCard
    },
    layout: Layout,
    props: {
        errors: Object
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post("/register", this.form)
        },
    },
}
</script>

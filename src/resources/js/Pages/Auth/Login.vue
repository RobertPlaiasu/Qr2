<template>
    <AuthCard>
        <form @submit.prevent="submit">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div>
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
                    class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow"
                    type="password" name="password" required autocomplete="current-password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input v-model="form.remember" id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">Loghează-mă automat</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link href="/forgot-password"
                            class="underline text-sm text-gray-600 hover:text-gray-900">
                    Ți-ai uitat parola?
                </inertia-link>

                <button type="submit"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Autentificare
                </button>
            </div>

            <div class="mt-4 border-t-2 text-center">
                <div class="p-2">
                    Nu ai cont?
                    <inertia-link href="/register" class="underline">
                        Fă-ți unul acum.
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
        status: String,
        errors: Object,
        forgot_password_enabled: Boolean,
    },
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(('/login'), this.form)
        },
    },
}
</script>

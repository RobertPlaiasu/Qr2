<template>
    <AuthCard>

        <div class="mb-4 text-sm text-gray-600">
            Ți-ai uitat parola? Nicio problemă. Doar lasă-ne emailul asociat contului, iar noi îți vom trimite 
            un link care îți perimite să schimbi parola.
        </div>

        <div v-if="status.length" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">
                    Email:
                </label>
                <input v-model="form.email" id="email" type="email" name="email" required
                       class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded shadow">
                <div v-if="errors.email" class="text-red-700">{{ errors.email[0] }}</div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Trimite link pentru resetarea parolei
                </button>
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
    props: {
        status: String,
        errors: Object,
    },
    data() {
        return {
            form: {
                email: '',
            },
        }
    },
    layout: Layout,
    methods: {
        submit() {
            this.$inertia.post("/forgot-password", this.form)
        },
    },
}
</script>

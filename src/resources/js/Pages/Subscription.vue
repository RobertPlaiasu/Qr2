<template>
    <app-layout :user="this.currentUser">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Abonament - Plata
            </h2>
        </template>
    <div v-if="Object.keys(errors).length > 0">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert" v-for="prop in Object.keys(errors)" v-bind:key="prop">
                <p class="font-bold">Eroare</p>
                <p>{{ errors[prop] }}</p>
        </div>
    </div>
    <form @submit.prevent="submit" :data-secret="intent.client_secret">
        <div class="lg:w-2/3 w-full mx-auto mt-8">
            <div class="flex flex-wrap -mx-2 mt-8 justify-center">
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="first_name" class="leading-7 text-sm text-gray-600">Prenume</label>
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.first_name"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="last_name" class="leading-7 text-sm text-gray-600">Nume</label>
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.last_name"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4 justify-center">
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="address" class="leading-7 text-sm text-gray-600">Adresa</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.address"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="city" class="leading-7 text-sm text-gray-600">Localitatea</label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.city"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4 justify-center">
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="state" class="leading-7 text-sm text-gray-600">Judet</label>
                        <input
                            type="text"
                            id="state"
                            name="state"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.state"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
                <div class="p-2 w-1/3">
                    <div class="relative">
                        <label for="zip_code" class="leading-7 text-sm text-gray-600">Cod postal</label>
                        <input
                            type="text"
                            id="zip_code"
                            name="zip_code"
                            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.customer.zip_code"
                            :disabled="paymentProcessing"
                        >
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-2 mt-4 justify-center">
                <div class="p-2 w-2/3">
                    <div class="relative">
                        <label for="card-element" class="leading-7 text-sm text-gray-600">Credit Card</label>
                        <div id="card-element"></div>
                    </div>
                </div>
            </div>
            <div class="p-2 w-full">
                <button
                    type="submit"
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                    :disabled="paymentProcessing"
                    v-text="paymentProcessing ? 'Proceseaza' : 'Plateste acum'"
                ></button>
            </div>
        </div>
    </form>
    </app-layout>
</template>
<script>
import { loadStripe } from '@stripe/stripe-js';
import AppLayout from './../Layouts/AppLayout'

export default{
    data:  function(){
        return {
            stripe: {},
            cardElement: {},
            form: {
                customer: {
                    first_name: '',
                    last_name: '',
                    address: '',
                    city: '',
                    state: '',
                },
            },
            paymentProcessing: false,
        }
    },
    async mounted() {
            this.stripe = await loadStripe(this.stripeKey);
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                classes: {
                    base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
                }
            });
            this.cardElement.mount('#card-element');
            console.log(this.stripe);
        },
        methods: {
            async submit() {
                console.log(this.intent.client_secret);
                this.paymentProcessing = true;
                const {setupIntent, error} = await this.stripe.confirmCardSetup(
                    this.intent.client_secret, {
                        payment_method: {
                            card: this.cardElement,
                            billing_details: {
                                name: this.form.customer.first_name + ' ' + this.form.customer.last_name,
                                email: this.currentUser.email,
                                address: {
                                    line1: this.form.customer.address,
                                    city: this.form.customer.city,
                                    state: this.form.customer.state,
                                }
                            }
                        }
                    }
                );
                if (error) {
                    this.paymentProcessing = false;
                    console.error(error);
                } else {
                    await console.log(setupIntent);
                    console.log(this.plan);
                    this.form.customer.payment_method_id = setupIntent.payment_method;
                    this.form.customer.plan = this.plan;
                    this.$inertia.post('/plati/abonament',this.form.customer)
                    .then((response) => {
                        this.paymentProcessing = false;
                            console.log(response);
                    })
                    .catch((error) => {
                        this.paymentProcessing = false;
                        console.error(error);
                    });;
                }
            }
        },
    props:[
        'currentUser',
        'title',
        'plan',
        'intent',
        'stripeKey',
        'errors',
    ],

    components: { AppLayout,},

    watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
}
</script>

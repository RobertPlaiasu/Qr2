<template>
    <div>
        <Navbar />
        <main>
            <div id="hero-banner">
                <div class="text-center">
                    <div class="text-4xl font-medium uppercase">Abonament Standard</div>
                    <div class="text-2xl font-medium">{{price}}</div>
                </div>
            </div>
            <div class="flex justify-center bg-white -mt-8 p-8 max-w-lg shadow-md mx-auto">
                <div>
                    <div class="text-center text-medium font-bold mb-4">Functionalitati incluse in abonament:</div>
                    <ul class="mt-4 list-disc">
                        <li class="mt-2">Abonamentul include 3 restaurante</li>
                        <li class="mt-2">Un user poate avea maxim 3 restaurante</li>
                        <li class="mt-2">Poti genera un cod QR pentru meniu</li>
                        <li class="mt-2">Ai un numar infinit de produse si promotii</li>
                        <li class="mt-2">Odata ce abonamentul nu mai este platit restaurantele dispar</li>
                        <li class="mt-2">Pentru informatii suplimentare contactati un <inertia-link href="/contact" >administrator</inertia-link></li>
                    </ul>
                    <inertia-link href="/abonamente">
                        <button type="button" class="mt-6 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            Devino abonat
                        </button>
                    </inertia-link>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue'

export default {
    props: ['price'],
    components: { Navbar },
}
</script>

<style>
    body, html
    {
        margin: 0;
        font-family: 'Nunito';
    }

    #hero-banner {
        background-image: linear-gradient(90deg, rgba(75,71,222,.9) 0%, rgba(139,92,246,.8) 100%), url('http://localhost/img/picture-subscription.jpg');
        width: 100%;
        height: 20em;
        background-size: cover;
        background-attachment: scroll;
        background-position: center;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
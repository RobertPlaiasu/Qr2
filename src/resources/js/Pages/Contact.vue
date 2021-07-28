<template>
    <div>
        <Navbar />
        <main>
            <div id="hero-banner">
                <div class="text-center">
                    <div class="text-4xl font-medium uppercase">Contactează-ne</div>
                    <div>Suntem disponibili la orice oră. Uite cum poți lua legătura cu noi</div>
                </div>
            </div>
            <div class="bg-white -mt-8 p-8 max-w-lg shadow-md mx-auto text-center">
                <div class="text-medium font-bold mb-4">Scrie-ne pe una din adresele de mai jos, iar noi îți vom răspunde cât mai rapid</div>
                <div>grigorescu.aleex@gmail.com</div>
                <div>robertplaiasu03@gmail.com</div>
            </div>
        </main>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue'

export default {
    components: { Navbar }
}
</script>

<style>
    body, html
    {
        margin: 0;
        font-family: 'Nunito';
    }

    #hero-banner {
        background-image: linear-gradient(90deg, rgba(75,71,222,.9) 0%, rgba(139,92,246,.8) 100%), url('http://localhost/img/template.jpg');
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
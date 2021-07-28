<template>
    <div>
        <Navbar />
            
        <!-- Content -->
        <main class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
            <div class="text-center">
                <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                    Meniul digital pentru
                    <br class="xl:hidden">
                    <span class="text-indigo-600">afacerea ta</span>
                </h2>
                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                    Digital Menu este o platformă din România ce face administrarea restaurantului și a meniului mult mai facilă și rapidă cu ajutorul tehnologiei
                </p>
                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-center">
                    <div class="rounded-md shadow">
                        <inertia-link href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                            Înscrieți restaurantul
                        </inertia-link>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";

export default {
    components: { Navbar }
}
</script>
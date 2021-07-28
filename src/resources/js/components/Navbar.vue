<template>
    <div class="relative z-10 py-3 container mx-auto text-center relative overflow-hidden">

        <!-- Computer Navbar -->
        <div class="relative px-4 sm:px-6 lg:px-8">
            <nav class="relative flex items-center justify-between sm:h-10 lg:justify-center">
                <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                    <div class="flex items-center justify-between w-full md:w-auto">
                        <inertia-link href="/" aria-label="Home">
                            <img class="h-8 w-auto sm:h-10" :src="logo" alt="Logo">
                        </inertia-link>
                        <div class="-mr-2 flex items-center md:hidden">
                            <button @click="toggleNavbar();" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" id="main-menu" aria-label="Main menu" aria-haspopup="true">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block md:ml-10 md:pr-4">
                    <inertia-link :href="pricing" class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Prețuri</inertia-link>
                    <inertia-link :href="contact" class="ml-8 font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Contact</inertia-link>
                    <a :href="manual" class="ml-8 font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Manual</a>
                    <inertia-link :href="register" class="ml-8 font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Înregistrare</inertia-link>
                    <inertia-link :href="login" class="ml-8 font-medium text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">Loghează-te</inertia-link>
                </div>
            </nav>
        </div>

        <!-- Phone Navbar -->
        <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right hidden" id="phoneNavbar">
            <div class="rounded-lg shadow-md">
                <div class="rounded-lg bg-white shadow-xs overflow-hidden" role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
                    <div class="px-5 pt-4 flex items-center justify-between">
                        <div>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-on-white.svg" alt="">
                        </div>
                        <div class="-mr-2">
                            <button type="button" @click="toggleNavbar();" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Close menu">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-2 pt-2 pb-3">
                        <inertia-link href="{pricing}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Prețuri</inertia-link>
                        <inertia-link href="{contact}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Contact</inertia-link>
                        <inertia-link href="{manual}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Manual</inertia-link>
                        <inertia-link href="{register}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Înregistrare</inertia-link>
                    </div>
                    <div>
                    <inertia-link href="{login}" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out" role="menuitem">
                        Loghează-te
                    </inertia-link>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            pricing: "/preturi",
            contact: "/contact",
            manual: "/manual",
            register: "/register",
            login: "/login",
            logo: 'http://localhost/img/logo.svg'
        }
    },

    methods: {
        toggleNavbar() {
            let navbar = document.getElementById("phoneNavbar");
            navbar.classList.toggle("hidden");
        }
    },
}
</script>
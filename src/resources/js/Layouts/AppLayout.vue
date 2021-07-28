<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">

            <!-- Primary Navigation Menu -->
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">

                        <!-- Logo -->
                        <div class="flex items-center flex-shrink-0">
                            <inertia-link href="/dashboard">
                                <jet-application-mark class="block w-auto h-9" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex" v-if="user.username !== 'Guest'">
                            <jet-nav-link href="/dashboard" :active="$page.currentRouteName == 'dashboard' && !showingRestaurantsDropdown">
                                Acasă
                            </jet-nav-link>
                            <jet-nav-link v-if="user.restaurants.length == 1" :active="$page.currentRouteName == 'restaurants.show'" :href="restaurantLink(user.restaurants[0])">
                                <p v-if="user.restaurants[0].model != null"> {{ user.restaurants[0].model.name }}  </p>
                                <p v-else> Creează restaurant </p>
                            </jet-nav-link>
                            <jet-dropdown align="left" width="48" v-else-if="user.restaurants.length > 1" @click="showingRestaurantsDropwdown = !showingRestaurantsDropwdown">
                                <template #trigger>
                                    <p class="mt-5 font-medium text-gray-500 cursor-pointer focus:text-black">Restaurante</p>
                                </template>

                                <template #content>
                                    <jet-dropdown-link v-for="restaurant in filteredRestaurants" :key="restaurant.model ? restaurant.model.id : null" :href="restaurantLink(restaurant)">
                                        <p v-if="restaurant.model"> {{ restaurant.model.name }} </p>
                                        <p v-else-if="restaurant.role.id == 2">Creează restaurant</p>
                                    </jet-dropdown-link>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6" >
                        <div class="relative ml-3" v-if="user.username !== 'Guest'">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                        <img class="object-cover w-8 h-8 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Managementul Profilului
                                    </div>

                                    <jet-dropdown-link href="/user/profile">
                                        Profil
                                    </jet-dropdown-link>

                                    <jet-dropdown-link href="/invitations">
                                        Invitații
                                    </jet-dropdown-link>

                                    <jet-dropdown-link href="/admin"  v-if="user.isAdmin">
                                        Admin
                                    </jet-dropdown-link>

                                    <div class="hidden sm:block">
                                        <div class="py-2">
                                            <div class="border-t border-gray-200"></div>
                                        </div>
                                    </div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Deconectare
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                        <jet-nav-link href="/dashboard" v-else>
                            Loghează-te
                        </jet-nav-link>
                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center -mr-2 sm:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div v-if="user.username !== 'Guest'">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link href="/dashboard" :active="$page.currentRouteName == 'dashboard'">
                            Acasă
                        </jet-responsive-nav-link>
                        <jet-responsive-nav-link v-for="restaurant in filteredRestaurants" :key="restaurant.model ? restaurant.model.id : null" :href="restaurantLink(restaurant)">
                            <p v-if="restaurant.model"> {{ restaurant.model.name }} </p>
                            <p v-else>Creează restaurant</p>
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <img class="w-10 h-10 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                            </div>

                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ $page.user.name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ $page.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link href="/user/profile" :active="$page.currentRouteName == 'profile.show'">
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link href="/invitations" :active="$page.currentRouteName.includes('invitation')">
                                Invitații
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link href="/admin" :active="$page.currentRouteName == 'admin'" v-if="user.isAdmin">
                                Admin
                            </jet-responsive-nav-link>

                            <div class="hidden sm:block">
                                <div class="py-2">
                                    <div class="border-t border-gray-200"></div>
                                </div>
                            </div>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Deconectare
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <jet-responsive-nav-link href="/login" class="pt-2 pb-1">
                        Loghează-te
                    </jet-responsive-nav-link>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'
    import JetApplicationMark from './../Jetstream/ApplicationMark'
    import JetDropdown from './../Jetstream/Dropdown'
    import JetDropdownLink from './../Jetstream/DropdownLink'
    import JetNavLink from './../Jetstream/NavLink'
    import JetResponsiveNavLink from './../Jetstream/ResponsiveNavLink'
    import JetSectionBorder from './../Jetstream/SectionBorder'

    export default {
        components: {
            JetApplicationLogo,
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            JetSectionBorder
        },

        props: [
            'user',
        ],

        data() {
            return {
                showingNavigationDropdown: false,
                showingRestaurantsDropdown: false,
            }
        },

        methods: {
            compareRestaurants(a, b) {
                if (a.model > b.model) return 1;
                if (a.model < b.model) return -1;
                return 0
            },

            restaurantLink(restaurant)
            {
                if (restaurant.model) return restaurant.uri;
                return '/restaurants/create';
            },

            logout() {
                axios.post('/logout').then(response => {
                    window.location = '/';
                })
            },
        },

        computed: {
            filteredRestaurants()
            {
                const restaurants = this.user.restaurants;

                for(let i = 0; i <= restaurants.length - 2; i++)
                {
                    for(let j = i + 1; j <= restaurants.length - 1; j++){
                        if (restaurants[i].model === null) {
                            let restaurant = restaurants[i];
                            restaurants[i] = restaurants[j];
                            restaurants[j] = restaurant;
                        }
                    }
                }

                return restaurants;
            },

            path() {
                return window.location.pathname
            }
        },
    }
</script>
<style scoped>
    .tooltip .tooltip-text
    {
        display: none;
        position: absolute;
        margin-top: 4.5em;
    }

    .tooltip:hover .tooltip-text
    {
        display: block;
    }

</style>

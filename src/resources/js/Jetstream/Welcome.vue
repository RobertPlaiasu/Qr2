<template>
    <div>
        <!-- Main Card -->
        <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
            <div>
                <jet-application-logo class="block w-auto h-12" />
            </div>

            <div class="mt-8 text-2xl">
                Bun venit, {{ user.username }}!
            </div>

            <div class="mt-6 text-gray-500">
                Echipa Digital Menu dorește să vă ofere o mână de ajutor prin crearea acestei platforme inovativă
                ce pune la dispoziție o implementare modernă a clasicilor meniuri cu ajutorul tehnologiei. Cea mai importantă parte fiind
                transformarea meniului fizic într-unul digital ce poate fi modificat în orice secundă și accesat prin scanarea unui cod QR.
                <br>
                În cazul în care întâmpinați probleme pe parcursul folosirii platformei noastre click <a href="/manual" class="link">aici</a> pentru a
                consulta manualul. Dacă tot nu găsiți o rezolvare ne puteți contacta <a href="/contact" class="link">aici</a>
            </div>
        </div>

        <!-- Restaurants Cards -->
        <a :href="restaurantUri(restaurant)" class="flex items-center justify-between p-8 m-2 font-bold rounded-lg shadow-lg text-md restaurant-card" v-for="restaurant in filteredRestaurants" :key="restaurant ? restaurant.id : null">
            <div v-if="restaurant.model != null">
                Accesează {{ restaurant.model.name }}
            </div>
            <div v-else-if="restaurant.role.id == 2">
                Creează un restaurant
            </div>
        </a>
    </div>
</template>

<script>
    import JetApplicationLogo from './../Jetstream/ApplicationLogo.vue'
    import InfoCard from '../components/InfoCard/InfoCard.vue'
    import InfoCardAnchor from "../components/InfoCard/InfoCardAnchor.vue";
    import InfoCardDisabledAnchor from "../components/InfoCard/InfoCardDisabledAnchor.vue";
    import CustomLink from "../components/Table/CustomLink.vue";

    export default {
        props: [ 'user' ],

        components: {
            JetApplicationLogo,
            InfoCard,
            InfoCardAnchor,
            InfoCardDisabledAnchor,
            CustomLink
        },

        methods: {
            restaurantUri(restaurant)
            {
                if (restaurant.model) return restaurant.uri;
                return '/restaurants/create';
            }
        },

        computed: {
            filteredRestaurants()
            {
                const restaurants = this.user.restaurants;

                for(let i = 0; i < restaurants.length; i++)
                {
                    let restaurant = restaurants[i];
                    if (restaurant === null) {
                        for(let  j = i; j < restaurants.length - 1; j++)
                            restaurants[j] = restaurants[j + 1];
                        this.user.restaurants[restaurants.length - 1] = restaurant;
                    }
                }

                return restaurants;
            },
        }
    }
</script>
<style lang="css">
    a.link{
        color: #8B5CF6;
        text-decoration: underline;
    }

    .restaurant-card{
        background-image: linear-gradient(to right, rgba(234, 237, 237,0.9), rgba(255,255,255,1)45%), url('https://restaurant.hoteldiesel.ro/wp-content/uploads/2012/10/slider-7.jpg');
        background-size:initial;
        background-repeat: no-repeat;
        background-position-y: bottom;
    }
    .restaurant-card:hover {
        border-bottom: solid 4px #8B5CF6;
        font-size: 1.1rem;
    }
</style>

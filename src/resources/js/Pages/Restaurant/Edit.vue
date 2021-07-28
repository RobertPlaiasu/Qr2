<template>
    <form-view>
        <form-element :title="`Informații ${restaurant.name}`">
            <!-- Name Field -->
            <input-text name="Nume" :edit="form.name" @changed="form.name = $event" :error="errors.name" />

            <!-- Description Field -->
            <input-text-area name="Descriere" :placeholder="form.description" @changed="form.description = $event" :error="errors.description"/>

            <div class="flex flex-wrap">
                <!-- City Field -->
                <div class="w-full lg:w-1/2 lg:pr-4">
                    <input-select
                        name="Oraș"
                        :items="filteredCities"
                        :hasSearch="true"
                        :selected="selectedCity"
                        :error="errors.city_id"
                        @changed="form.city_id = $event"
                    />
                </div>

                <!-- Adress Field -->
                <div class="w-full lg:w-1/2 lg:pl-4">
                    <input-text name="Adresă" :edit="form.location" @changed="form.location = $event" :error="errors.location"/>
                </div>
            </div>

            <div @click="updateRestaurant" class="text-center">
                <input-submit :loading="loading"/>
            </div>
        </form-element>
    </form-view>
</template>

<script>
    import FormView from '../../components/Form/FormView.vue';
    import FormElement from '../../components/Form/FormElement.vue';
    import InputText from '../../components/Inputs/InputText.vue';
    import InputTextArea from '../../components/Inputs/InputTextArea.vue';
    import InputSelect from '../../components/Inputs/InputSelect.vue';
    import InputSubmit from '../../components/Inputs/InputSubmit.vue';

    export default {
        props: ['restaurant', 'city', 'errors', 'cities', 'title'],
        components: { 
            FormElement,
            FormView,
            InputText,
            InputTextArea,
            InputSelect,
            InputSubmit,
        },

        data() {
            return {
                loading: false,
                form: {
                    name: this.restaurant.name,
                    description: this.restaurant.description,
                    location: this.restaurant.location,
                    city_id: this.city
                }
            }
        },

        methods: {
            updateRestaurant() {
                this.loading = true;
                this.$inertia.put(this.restaurant.uri, this.form)
                    .then(() => {
                        this.loading = false;
                    })
            },
        },

        computed: {
            filteredCities() {
                return this.cities.map( city => {
                    return {
                        id: city.id,
                        name: city.name
                    };
                });
            },

            selectedCity() {
                for(let i = 0; i < this.cities.length; i++)
                    if(this.cities[i].id === this.form.city_id)
                        return {
                            id: this.cities[i].id,
                            name: this.cities[i].name
                        }
            }
        },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

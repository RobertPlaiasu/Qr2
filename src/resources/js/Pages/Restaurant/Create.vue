<template>
    <form-view>
        <form-element title="Înregistrare restaurant">
            <!-- Name Field -->
            <input-text name="Nume" placeholder="Numele restaurantului tau" @changed="form.name = $event" :error="errors.name" />

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
                    <input-text name="Adresă" placeholder="Str. Copac nr. 43" @changed="form.location = $event" :error="errors.location"/>
                </div>
            </div>

            <input type="file" @change="onFileSelected" />
            <error-message :error="errors.picture"/>

            <div @click="createRestaurant" class="text-center">
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
        props: ['errors', 'cities', 'title'],
        components: { 
            FormElement,
            FormView,
            InputText,
            InputTextArea,
            InputSelect,
            InputSubmit,
        },

        data: function() {
            return {
                loading: false,
                form: this.$inertia.form({
                    name: '',
                    description: "La noi mancarea este gatita conform retetelor din Dacia",
                    location: '',
                    city_id: this.cities[0].id,
                    picture: null,
                })
            }
        },

        methods: {
            createRestaurant() {
                this.loading = true;
                this.form.post(`/restaurants`)
                    .then(() => {
                        this.loading = false;
                    })
            },

            onFileSelected(event) {
                this.form.picture = event.target.files[0];
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

<template>
    <form-view>
        <form-element title="Adăugare oraș">
            <input-text name="Nume" placeholder="Sibiu" @changed="form.name = $event" :error="errors.name" />

            <input-select
                name="Județ"
                :items="filteredCounties"
                :hasSearch="true"
                :selected="selectedCounty"
                :error="errors.county_id"
                @changed="form.county_id = $event"
            />

                <div @click="createCity" class="text-center">
                    <input-submit :loading="loading"/>
                </div>
        </form-element>
    </form-view>
</template>

<script>
    import FormView from '../../components/Form/FormView.vue';
    import FormElement from '../../components/Form/FormElement.vue';
    import InputText from '../../components/Inputs/InputText.vue';
    import InputSelect from '../../components/Inputs/InputSelect.vue';
    import InputSubmit from '../../components/Inputs/InputSubmit.vue';

    export default {
        props: ['errors', 'counties', 'title'],
        components: { FormElement, FormView, InputText, InputSelect, InputSubmit },

        data() {
            return {
                loading: false,
                form: {
                    name: '',
                    county_id: this.counties[0].id
                }
            }
        },

        methods: {
            createCity() {
                this.loading = true;
                this.$inertia.post(`/cities`, this.form)
                    .then(() => {
                        this.loading = false;
                    })
            },
        },

        computed: {
            filteredCounties() {
                return this.counties.map(county => {
                    return {
                        id: county.id,
                        name: county.name
                    }
                })
            },

            selectedCounty() {
                for(let i = 0; i < this.counties.length; i++)
                    if(this.counties[i].id === this.form.county_id)
                        return {
                            id: this.counties[i].id,
                            name: this.counties[i].name
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

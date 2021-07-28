<template>        
    <form-view>
        <form-element title="Adăugare preparat">
            <form @submit.prevent="create">
                <input-text v-model="form.name" name="Nume" placeholder="Nume preparat" @changed="form.name = $event" :error="errors.name" />
                <input-number v-model="form.price" name="Pret" @changed="form.price = $event" :error="errors.price" />
                <input-number v-model="form.weight" name="Gramaj" @changed="form.weight = $event" :error="errors.weight" />
                <input-text v-model="form.ingredients" name="Ingrediente" placeholder="oua, lapte" @changed="form.ingredients = $event" :error="errors.ingredients" />
                
                <input type="file" @change="onFileSelected" />
                <error-message :error="errors.picture"/>

                <div class="text-center"> <input-submit :loading="loading"/> </div>
            </form>
        </form-element>
    </form-view>
</template>

<script>
    import FormView from '../../components/Form/FormView.vue';
    import FormElement from '../../components/Form/FormElement.vue';
    import InputText from '../../components/Inputs/InputText.vue';
    import InputNumber from '../../components/Inputs/InputNumber.vue';
    import InputSubmit from '../../components/Inputs/InputSubmit.vue';
    import ErrorMessage from '../../components/Form/ErrorMessage.vue';

    export default {
        props: ['errors', 'category', 'title'],
        components: { FormElement, FormView, InputText, InputSubmit, InputNumber, ErrorMessage },

        data() {
            return {
                loading: false,
                form: this.$inertia.form({
                    name: null,
                    price: null,
                    weight: null,
                    picture: null,
                    ingredients: null,
                })
                }
            },

        methods: {
            create() {
                this.loading = true;
                console.log(this.form);
                this.form.post(`/categories/${this.category}/products`)
                    .then(() => {
                        this.loading = false;
                    })
            },

            onFileSelected(event) {
                this.form.picture = event.target.files[0];
            },
        },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

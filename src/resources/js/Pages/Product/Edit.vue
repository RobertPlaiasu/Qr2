<template>        
    <form-view>
        <form-element :title="title">
            <form @submit.prevent="edit">
                <input-text name="Nume" :edit="form.name" placeholder="Nume preparat" @changed="form.name = $event" :error="errors.name" />
                <input-number name="Pret" :edit="form.price" @changed="form.price = $event" :error="errors.price" />
                <input-number name="Gramaj" :edit="form.weight" @changed="form.weight = $event" :error="errors.weight" />
                <input-text name="Incrediente" :edit="form.incredients" placeholder="oua, lapte" @changed="form.incredients = $event" :error="errors.incredients" />
                
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
        props: ['errors', 'product', 'title', 'category_id'],
        components: { FormElement, FormView, InputText, InputSubmit, InputNumber, ErrorMessage },

        data() {
            return {
                loading: false,
                form: this.$inertia.form({
                    name: this.product.name,
                    price: this.product.price,
                    weight: this.product.weight,
                    incredients: this.product.incredients,
                    picture: null,
                    category_id: this.category_id
                })
                }
            },

        methods: {
            edit() {
                this.loading = true;
                this.form.put("/products/" + this.product.id)
                    .then(() => {
                        this.loading = false;
                    })
            },

            onFileSelected(event) {
                this.form.picture = event.target.files[0];
                console.log(this.form.picture);
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

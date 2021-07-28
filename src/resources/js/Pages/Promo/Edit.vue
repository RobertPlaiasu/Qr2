<template>        
    <form-view>
        <form-element title="Adăugare promotie">
            <form @submit.prevent="create">
                <input-text name="Nume" :edit="form.name"  placeholder="Nume promotie" v-model="form.name" @changed="form.name = $event" :error="errors.name" />
                <input-number name="Pret" :edit="form.price"  v-model="form.price"  @changed="form.price = $event" :error="errors.price" />
                <date name="Data expirare" v-model="form.expire" @changed="form.expire = $event" :error="errors.expire"/>
                <div class="mt-3">
                    <label class="block text-sm text-gray-00" for="description">Produse din promotie</label>
                    <select class="w-full py-3 px-4 pr-8 text-gray-700 bg-gray-200 rounded" v-model="form.products" required="" multiple>
                        <option v-for="product in products" :key="product.id" :value="product.id" :selected="checkProductSelected(promo)"> {{ product.name }} </option>
                    </select>
                    <error-message :error="errors.products"/>
                </div>
                <div class="mt-3">
                    <h3>Poza</h3>
                    <input type="file" @change="onFileSelected" />
                    <error-message :error="errors.picture"/>
                </div>
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
    import Date from '../../components/Date.vue';

    export default {
        props: ['errors', 'menu','products' ,'title','promo','currentProducts'],
        components: { FormElement, FormView, InputText, InputSubmit, InputNumber, ErrorMessage, Date },

        data() {
            return {
                loading: false,
                form: this.$inertia.form({
                    name: this.promo.name,
                    price: this.promo.price,
                    picture: null,
                    expire: null,
                    products: this.currentProducts.map( (product) => {return product.id;} ),
                })
                }
            },

        methods: {
            create() {
                this.loading = true;
                console.log(this.form);
                this.form.put(this.menu + "/promos/" + this.promo.id)
                    .then(() => {
                        this.loading = false;
                    })
            },

            onFileSelected(event) {
                this.form.picture = event.target.files[0];
                console.log(this.form.picture);
            },

            checkProductSelected( product ) {
                return this.form.products.includes(product);
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
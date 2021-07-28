<template>
    <form-view>
        <form-element title="Adăugare categorie">
            <input-text 
                name="Nume" 
                placeholder="Nume categorie"
                @changed="form.name = $event" 
                :error="errors.name" 
            />

            <div @click="createCategory" class="text-center">
                <input-submit :loading="loading"/>
            </div>
        </form-element>
    </form-view>
</template>

<script>
import FormView from '../../components/Form/FormView.vue';
import FormElement from '../../components/Form/FormElement.vue';
import InputText from '../../components/Inputs/InputText.vue';
import InputSubmit from '../../components/Inputs/InputSubmit.vue';

export default {
    props: ['errors', 'menu', 'title'],
    components: { FormElement, FormView, InputText, InputSubmit },

    data() {
        return {
            loading: false,
            form: {
                name: '',
                menu_id: this.menu
            }
        }
    },

    methods: {
        createCategory() {
            this.loading = true;
            this.$inertia.post(`${this.menu}/categories`, this.form)
                .then(() => {
                    this.loading = false;
                })
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

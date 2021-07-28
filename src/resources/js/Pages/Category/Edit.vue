<template>
    <form-view>
        <form-element :title="`Modificare ${ category.name }`">
            <input-text name="Nume" :edit="form.name" @changed="form.name = $event" :error="errors.name" />
            <div @click="updateCategory" class="text-center">
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
        props: ['category', 'menu', 'errors', 'title', ],
        components: { FormElement, FormView, InputText, InputSubmit },

        data() {
            return {
                loading: false,
                form: {
                    name: this.category.name,
                    menu_id: this.menu
                }
            }
        },

        methods: {
            updateCategory() {
                this.loading = true;
                this.$inertia.put(`${this.menu}/categories/${this.category.id}`, this.form)
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

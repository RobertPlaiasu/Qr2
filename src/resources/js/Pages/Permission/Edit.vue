<template>
    <form-view>
        <form-element :title="`Modificare - ${permission.name}`">
            <input-text 
                name="Nume" 
                :edit="form.name" 
                @changed="form.name = $event" 
                :error="errors.name" 
            />

            <input-text 
                name="Descriere" 
                :edit="form.description" 
                @changed="form.description = $event" 
                :error="errors.description" 
            />

            <div @click="editPermission" class="text-center">
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
        props: ['errors', 'permission', 'title'],
        components: { FormElement, FormView, InputText, InputSubmit, },

        data() {
            return {
                loading: false,
                    form: {
                        name: this.permission.name,
                        description: this.permission.description
                    }
                }
            },

        methods: {
            editPermission() {
                this.loading = true;
                this.$inertia.put(`/permissions/${this.permission.id}`, this.form)
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

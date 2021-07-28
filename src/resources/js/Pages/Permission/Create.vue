<template>
    <form-view>
        <form-element title="Adăugare Permisiune">
            <input-text 
                :error="errors.name" 
                @changed="form.name = $event" 
                name="Nume" 
                placeholder="Modificare nume produs" 
            />

            <input-text 
                @changed="form.description = $event" 
                :error="errors.description" 
                name="Descriere" 
                placeholder="Poate modificate numele unui produs din meniu" 
            />

            <div @click="createPermission" class="text-center">
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
        props: ['errors', 'title'],
        components: { FormElement, FormView, InputText, InputSubmit },

        data() {
            return {
                loading: false,
                    form: {
                        name: '',
                        description: ''
                    }
                }
            },

        methods: {
            createPermission() {
                this.loading = true;
                this.$inertia.post(`/permissions`, this.form)
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

<template>
    <form-view>
        <form-element title="Adăugare Județ">
            <input-text name="Nume" placeholder="Ilfov" @changed="form.name = $event" :error="errors.name" />
            <div @click="createCounty" class="text-center">
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
                }
            }
        },

        methods: {
            createCounty() {
                this.loading = true;
                this.$inertia.post(`/counties`, this.form)
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

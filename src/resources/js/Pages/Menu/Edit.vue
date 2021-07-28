<template>
    <form-view>
        <form-element title="Editare Meniu">
            <input-text name="Nume" :edit="form.name" @changed="form.name = $event" :error="errors.name" />

            <div @click="editMenu" class="text-center">
                <input-submit :loading="loading" class="w-full"/>
            </div>
            <button 
                @click="deleteMenu(restaurant + menu.uri)"
                class="px-4 py-2 m-1 ml-0 w-full font-bold text-white bg-red-600 rounded shadow hover:bg-red-700"
            >
                Șterge
            </button>
        </form-element>
    </form-view>
</template>

<script>
    import FormView from '../../components/Form/FormView.vue';
    import FormElement from '../../components/Form/FormElement.vue';
    import InputText from '../../components/Inputs/InputText.vue';
    import InputSubmit from '../../components/Inputs/InputSubmit.vue';
    import CustomLink from '../../components/Table/CustomLink.vue'

    export default {
        props: ['errors', 'restaurant', 'menu', 'title'],
        components: { FormElement, FormView, InputText, InputSubmit, CustomLink },

        data() {
            return {
                loading: false,
                    form: {
                        name: this.menu.name,
                    }
                }
            },

        methods: {
            editMenu() {
                this.loading = true;
                this.$inertia.put(this.restaurant + this.menu.uri, this.form)
                    .then(() => {
                        this.loading = false;
                    })
            },

            deleteMenu (target) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acest restaurant?')) {
                    this.$inertia.delete(target);
                }
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

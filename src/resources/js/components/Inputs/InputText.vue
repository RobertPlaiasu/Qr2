<template>
    <div class="mt-3">
        <input-label> {{ name }} </input-label>
        <input
            v-model="value"
            :placeholder="placeholder"
            @change="$emit('changed', value)"
            type="text"
            class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded"
        />
        <error-message :error="error"/>
    </div>
</template>

<script>
    import InputLabel from './InputLabel.vue';
    import ErrorMessage from '../Form/ErrorMessage.vue';

    export default {
        props: ['name', 'placeholder', 'edit', 'error'],
        components: { InputLabel, ErrorMessage },

        data() {
            return {
                value: this.edit,
            }
        },
    }
</script>

<template>
    <div class="mt-3">
        <input-label> {{ name }} </input-label>
        <input
            v-model="value"
            @change="$emit('changed', value)"
            type="number"
            class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded"
        />
        <error-message :error="error"/>
    </div>
</template>

<script>
    import InputLabel from './InputLabel.vue';
    import ErrorMessage from '../Form/ErrorMessage.vue';

    export default {
        props: ['name', 'edit', 'error'],
        components: { InputLabel, ErrorMessage },

        data() {
            return {
                value: this.edit,
            }
        },
    }
</script>

<template>
    <div class="mt-3">
        <input-label>{{ name }}</input-label>
        <textarea
            v-model="value"
            @change="$emit('changed', value)"
            cols="30"
            rows="10"
            class="w-full px-4 py-3 pr-8 text-gray-700 bg-gray-200 rounded-md"
        ></textarea>

        <error-message :error="error"/>
    </div>
</template>

<script>
    import InputLabel from './InputLabel.vue';
    import ErrorMessage from '../Form/ErrorMessage.vue';

    export default {
        props: ['name', 'placeholder', 'error'],
        components: { InputLabel, ErrorMessage },

        data() {
            return { 
                value: this.placeholder 
            }
        },
    }
</script>

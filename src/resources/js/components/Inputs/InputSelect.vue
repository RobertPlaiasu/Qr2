<template>
    <div class="mt-3">
        <input-label>{{ name }}</input-label>
        
        <custom-select 
            :items="items" 
            :selected="selected" 
            :hasSearch="hasSearch" 
            @selected="$emit('changed', $event.id);"
        />

        <error-message :error="error"/>
    </div>
</template>

<script>
import InputLabel from './InputLabel.vue';
import CustomSelect from '../CustomSelect.vue'
import ErrorMessage from '../Form/ErrorMessage.vue';

export default {
    props: ['name', 'items', 'selected', 'hasSearch', 'error'],
    components: { InputLabel, CustomSelect, ErrorMessage },
}
</script>

<template>
  <div class="mt-3">
      <input-label> {{ name }} </input-label>
      <Datepicker  v-model="value" @change="$emit('changed', value)" placeholder="Data expirare promotie" format="dd-MM-yyyy"></Datepicker>
      <error-message :error="error"/>
  </div>
</template>
 
<script>

import InputLabel from './Inputs/InputLabel.vue';
import ErrorMessage from './Form/ErrorMessage.vue';
import Datepicker from 'vuejs-datepicker';

export default {
        props: ['name','edit', 'error'],
        components: { InputLabel, ErrorMessage, Datepicker },
        data() {
            return {
                value: this.edit,
            }
        },
    };
</script>
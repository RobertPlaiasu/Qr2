<template>
    <div class="relative mt-1">
        <dropdown-button :selected="selected" @click="open = !open"/>

        <dropdown-list v-if="open">
            <dropdown-list-item v-if="hasSearch">
                <input type="text" v-model="search" placeholder="Cauta" class="w-full p-2 text-black rounded">
            </dropdown-list-item>

            <dropdown-list-item v-for="item in filteredList" :key="item.id"  :item="item" @click="selectItem(item)">
                <div class="flex items-center">
                    <span class="block ml-3 font-normal truncate">
                        <p v-for="(value, key) in item" :key="key">
                            <span v-if="!key.includes('id')"> {{ value }} </span>
                        </p>
                    </span>
                </div>
                <checkmark v-if="item.id == selectedItem.id"/>
            </dropdown-list-item>
        </dropdown-list>
    </div>
</template>

<script>
import Checkmark from './Icons/Checkmark.vue';
import DropdownButton from './Dropdown/DropdownButton.vue';
import DropdownList from './Dropdown/DropdownList.vue';
import DropdownListItem from './Dropdown/DropdownListItem.vue'

export default {
    props: ['items', 'selected', 'hasSearch'],
    components: {Checkmark, DropdownButton, DropdownList, DropdownListItem},

    data() {
        return {
            open: false,
            selectedItem: this.selected,
            search: ''
        }
    },

    methods: {
        selectItem(item) {
            this.selectedItem = item;
            this.open = false;
            this.$emit('selected', item);
        },
    },

    computed: {
        filteredList() {
            return this.items.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    },
}
</script>

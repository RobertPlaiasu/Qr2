<template>
    <app-layout :user="currentUser">
        <template #header>
            <div class="flex flex-row items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
                    Lista meniuri 
                </h2>
            </div>
        </template>
        <div class="flex justify-around p-8">
            <custom-table 
                :items="generateMenus" 
                :uris="generateUris" 
                :customShow="genereateShowUris" 
                :hasShow="true"
                :hasEdit="true" 
                class="w-full"
            />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import CustomTable from '../../components/Table/CustomTable.vue';

    export default {
        props: ['currentUser', 'restaurants', 'menus', 'title'],
        components: { AppLayout, CustomTable },

        computed: {
            generateMenus() {
                return this.menus.map((menu, index) => {
                    return {
                        ID: menu.id,
                        Nume: menu.name,
                        Restaurant: this.restaurants[index].name
                    };
                });
            },

            genereateShowUris() {
                return this.menus.map((menu, index) => {
                    return menu.uri;
                });
            },

            generateUris() {
                return this.menus.map((menu, index) => {
                    return this.restaurants[index].uri + menu.uri;
                } );
            }
        },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

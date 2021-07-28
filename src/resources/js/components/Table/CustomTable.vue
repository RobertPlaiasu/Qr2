<template>
    <div class="mt-6 rounded shadow">
        <div v-if="items.length === 0">
            <p class="p-24 text-center bg-white">
                Nu există intrăti pentru aceast table, în caz contra ca rugăm să ne contactați. <br>
                <small> *Daca nu este cazul, vă rugăm contactați-ne </small>
            </p>
        </div>

        <div v-else>
            <table class="w-full whitespace-no-wrap bg-white table-auto">
                <thead>
                    <tr class="font-bold">
                        <custom-th v-for="(value, key) in items[0]" :key="key"> {{ key }} </custom-th>
                        <custom-th v-if="uris !== undefined"> Acțiuni </custom-th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) of items" :key="index">
                        <custom-td v-for="(value, key) in item" :key="value">
                            <p v-if="key === 'ID'"> {{ index + 1 }} </p>
                            <p v-else> {{ value }} </p>
                        </custom-td>

                        <custom-td v-if="uris !== undefined">
                            <custom-link :uri="customShow ? customShow[index] : uris[index]" color="indigo" v-if="hasShow"> Accesează pagina </custom-link>
                            <custom-link :uri="`${uris[index]}/edit`" v-if="hasEdit" color="orange"> Editează element </custom-link>
                            <div @click="deleteItem(uris[index])" class="inline"><custom-link color="red"> Șterge element </custom-link></div>
                        </custom-td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import CustomTd from "./CustomTd.vue";
    import CustomTh from "./CustomTh.vue";
    import CustomLink from "./CustomLink.vue";

    export default {
        props: ['items', 'uris', 'customShow', 'hasShow','hasEdit'],
        components: { CustomTd, CustomTh, CustomLink },

        methods: {
            deleteItem(target) {
                if (confirm('Sunteți sigur(ă) că doriți să stergeți acest obiect?'))
                    this.$inertia.delete(target);
            }
        },
    }
</script>

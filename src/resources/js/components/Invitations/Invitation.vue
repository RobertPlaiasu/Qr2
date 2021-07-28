<template>
    <div class="flex items-center justify-between w-full p-8 m-2 bg-white rounded-lg shadow">
        <p>
            <strong>{{ restaurant }}</strong> 
            dorește să te angajeze pe postul de {{ role }}
        </p>
        
        <div class="flex">
            <div @click="accept()"><custom-link color="green"> Acceptă </custom-link></div>
            <div @click="reject()"><custom-link color="red"> Refuză </custom-link></div>
        </div>
    </div>
</template>

<script>
    import CustomLink from '../Table/CustomLink.vue';

    export default {
        props: ['invitation_id', 'restaurant', 'role'],
        components: { CustomLink },

        methods: {
            accept() {
                this.$inertia.post(`/invitations/${this.invitation_id}/accept`);
            },

            reject() {
                this.$inertia.delete(`/invitations/${this.invitation_id}`);
            }
        },
    }
</script>

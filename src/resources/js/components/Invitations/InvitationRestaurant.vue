<template>
    <div class="flex items-center justify-between w-full p-8 m-2 bg-white rounded-lg shadow">
        <p>
            <strong>{{ username }}</strong> 
            a fost invitat pentru rolul de {{ role }}
        </p>
        
        <div class="flex">
            <div @click="cancel()"><custom-link color="red"> Anulează invitația </custom-link></div>
        </div>
    </div>
</template>

<script>
    import CustomLink from '../Table/CustomLink';

    export default {
        props: ['invitation_id', 'username', 'role'],
        components: { CustomLink },

        methods: {
            cancel() {
                this.$inertia.delete(`/invitations/${this.invitation_id}`);
            }
        },
    }
</script>

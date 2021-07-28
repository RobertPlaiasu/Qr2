<template>
    <app-layout :user="currentUser">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800"> Invitațiile tale </h2>
        </template>
        <div class="flex flex-col justify-around pt-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div v-if="invitations.length === 0">
                Nu ai fost invitat nicăieri momentan :(
            </div>
            <invitation
                v-for="(invitation, index) in invitations" :key="invitation.id"
                :invitation_id="invitation.id"
                :restaurant="restaurants[index].name"
                :role="roles[index].name"
                v-else
            />
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout.vue';
    import Invitation from '../../components/Invitations/Invitation.vue';

    export default {
        props: ['currentUser', 'invitations', 'restaurants', 'roles', 'title'],
        components: { AppLayout, Invitation },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

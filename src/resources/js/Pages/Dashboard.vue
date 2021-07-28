<template>
    <app-layout :user="this.currentUser">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Acasă
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome :user="this.currentUser"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'

    export default {
        props: [ 'currentUser', 'title' ],
        components: { AppLayout, Welcome },

        watch: {
            title: {
                immediate: true,
                handler(title) { document.title = title },
            },
        },
    }
</script>

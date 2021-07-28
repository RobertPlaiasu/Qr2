<template>
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-2xl font-medium text-gray-900 break-all">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1 text-sm text-gray-600 break-all">
                <slot name="description"></slot>
            </p>
        </div>
    </div>
</template>

<template>
    <div class="p-6">
        <div class="flex items-center">
            <slot name="title"></slot>
        </div>

        <!-- Menu card -->
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                <slot name="description"></slot>
            </div>
            <slot name="anchor"></slot>
        </div>
    </div>
</template>

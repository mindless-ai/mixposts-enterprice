<script setup>
import XIcon from "@/Icons/X.vue"

defineProps({
    count: {
        type: Number,
        required: true
    }
})
</script>
<template>
    <transition enter-active-class="transition ease-out duration-200"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
        <div v-show="count"
             class="fixed bottom-0 mb-sm py-md px-sm flex items-center bg-alert shadow-mix text-alert-context rounded-md mt-1 z-10">
            <div class="flex w-full items-center">
                <div class="flex items-center">
                    <button @click="$emit('close')" v-tooltip.top="$t('general.dismiss')"
                            class="mr-sm hover:text-red-500 transition-colors ease-in-out duration-200">
                        <XIcon/>
                    </button>
                    <div class="text-alert-context">
                        <span class="btn-black mr-xs">{{ count }}</span>
                        <span class="hidden sm:inline-block">{{ $t('general.items_selected') }}</span>
                        <span class="inline-block sm:hidden">{{ $t('general.selected') }}</span>
                    </div>
                </div>
                <div :class="{'ml-sm rtl:ml-0 rtl:mr-sm': $slots}" class="flex items-center">
                    <slot/>
                </div>
            </div>
        </div>
    </transition>
</template>

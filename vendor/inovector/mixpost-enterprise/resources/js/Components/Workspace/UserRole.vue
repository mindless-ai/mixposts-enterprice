<script setup>
import Radio from "@/Components/Form/Radio.vue";

const props = defineProps(['modelValue']);

const emits = defineEmits(['update:modelValue']);

const update = (val) => {
    emits('update:modelValue', val)
}
</script>
<template>
    <div>
        <div>
            <label class="flex items-start">
                <Radio v-bind:checked="modelValue" @update:checked="update" value="admin"/>

                <span class="flex flex-col ml-xs rtl:ml-0 rtl:mr-xs">
                    <span>{{ $t('team.admin') }}</span>
                    <span class="text-gray-500"> {{ $t('team.full_edit') }}</span>
                </span>
            </label>
        </div>

        <div class="mt-xs">
            <label class="flex items-start">
                <Radio v-bind:checked="modelValue" @update:checked="update" value="member"/>

                <span class="flex flex-col ml-xs rtl:ml-0 rtl:mr-xs">
                    <span>{{ $t('team.member') }}</span>
                    <span class="text-gray-500">{{ $t('team.limited_edit') }}</span>
                </span>
            </label>
        </div>

        <div class="mt-xs">
            <label class="flex items-start">
                <Radio v-bind:checked="modelValue" @update:checked="update" value="viewer"/>

                <span class="flex flex-col ml-xs rtl:ml-0 rtl:mr-xs">
                   <span>{{ $t('team.viewer') }}</span>
                   <span class="text-gray-500">{{ $t( 'team.viewer_access') }}</span>
                </span>
            </label>
        </div>
    </div>
</template>

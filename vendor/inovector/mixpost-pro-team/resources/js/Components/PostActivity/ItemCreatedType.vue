<script setup>
import TypeLayout from "./TypeLayout.vue";

defineProps({
    item: {
        required: true,
        type: Object
    }
});
</script>
<template>
    <TypeLayout>
        <template #default>
            {{ $t('post_activity.created_post', {user: item.user.name}) }}
        </template>
        <template #created_at>
            {{ item.timestamps.localized.created_at }}
        </template>
    </TypeLayout>
</template>

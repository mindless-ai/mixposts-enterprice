<script setup>
import {ref} from "vue";
import {clone, startsWith} from "lodash";
import Draggable from 'vuedraggable'
import usePost from "@/Composables/usePost";
import DialogModal from "@/Components/Modal/DialogModal.vue"
import MediaFile from "@/Components/Media/MediaFile.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";

const props = defineProps({
    media: {
        type: Array,
        required: true
    }
})

const emits = defineEmits(['updated']);

const {editAllowed} = usePost();

const showView = ref(false);
const openedItem = ref({});

const isVideo = (mime_type) => {
    return startsWith(mime_type, 'video')
}

const open = (item) => {
    openedItem.value = item;
    showView.value = true;
}

const close = () => {
    showView.value = false;
    openedItem.value = {};
}

const remove = (id) => {
    const index = props.media.findIndex(item => item.id === id);

    const items = clone(props.media);
    items.splice(index, 1);

    emits('updated', items);
    close();
}
</script>
<template>
    <div :class="{'mt-xs': media.length}">
        <Draggable
            :list="media"
            :disabled="!editAllowed"
            v-bind="{
                animation: 200,
                group: 'media'
            }"
            item-key="id"
            class="flex flex-wrap gap-xs"
        >
            <template #item="{element}">
                <div role="button" class="cursor-pointer" @click="open(element)">
                    <MediaFile :media="element" img-height="sm" :imgWidthFull="false" :showCaption="false"/>
                </div>
            </template>
        </Draggable>
    </div>

    <DialogModal :show="showView" @close="close">
        <template #header>
            {{ $t('post.view_media') }}
        </template>

        <template #body>
            <figure>
                <figcaption class="mb-xs text-sm">{{ openedItem.name }}</figcaption>

                <video v-if="isVideo(openedItem.mime_type)" class="w-auto h-full" controls>
                    <source :src="openedItem.url" :type="openedItem.mime_type">
                    {{ $t('error.browser_video_unsupported') }}
                </video>

                <img v-else :src="openedItem.url" alt="Image"/>
            </figure>
        </template>

        <template #footer>
            <SecondaryButton @click="close" class="mr-xs">{{ $t('general.close') }}</SecondaryButton>
            <DangerButton v-if="editAllowed" @click="remove(openedItem.id)">{{ $t('general.remove') }}</DangerButton>
        </template>
    </DialogModal>
</template>

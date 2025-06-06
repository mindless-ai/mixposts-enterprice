<script setup>
import {computed, inject} from "vue";
import {router} from "@inertiajs/vue3";
import {isDateTimePast} from "@/helpers";
import {addMinutes, format, getHours, parseISO} from "date-fns";
import {utcToZonedTime} from "date-fns-tz";
import CalendarPostItem from "@/Components/Calendar/CalendarPostItem.vue";
import PlusIcon from "@/Icons/Plus.vue"
import DisabledItemImg from "@img/calendar-disabled-item.svg"
import useDateLocalize from "../../../Composables/useDateLocalize";
import useWorkspace from "../../../Composables/useWorkspace.js";

const workspaceCtx = inject('workspaceCtx');

const props = defineProps({
    dateSlot: {
        type: String,
        required: true,
    },
    timeSlot: {
        type: String,
        required: true,
    },
    minuteSlot: {
        type: Object,
        required: true,
    },
    timeZone: {
        required: false,
        type: String,
        default: 'UTC'
    },
    timeFormat: {
        required: false,
        type: Number,
        default: 12
    },
    posts: {
        type: Array,
        required: true,
    },
})

const {translatedFormat} = useDateLocalize();
const {isWorkspaceEditorRole} = useWorkspace();

const isDisabled = computed(() => {
    const cellDateTimeMinute = addMinutes(parseISO(`${props.dateSlot} ${props.timeSlot}`), props.minuteSlot['end']);

    return isDateTimePast(cellDateTimeMinute, props.timeZone);
})

const label = computed(() => {
    const cellDateTimeMinute = addMinutes(parseISO(`${props.dateSlot} ${props.timeSlot}`), props.minuteSlot['start']);

    return translatedFormat(cellDateTimeMinute, `${props.timeFormat === 12 ? 'h:mm aaa' : 'H:mm'}`);
})

const style = computed(() => {
    if (!isDisabled.value) {
        return {};
    }

    return {
        backgroundImage: `url('${DisabledItemImg}')`
    }
})

const add = () => {
    if (!isWorkspaceEditorRole.value) return;

    let scheduleAt = `${props.dateSlot} ${props.timeSlot}`;

    const now = utcToZonedTime(new Date().toISOString(), props.timeZone);

    const today = format(now, 'yyyy-MM-dd')

    if (`${today} ${getHours(now)}:00` === scheduleAt) {
        scheduleAt = format(now, 'yyyy-MM-dd H:mm');
    }

    router.visit(route('mixpost.posts.create', {workspace: workspaceCtx.id, schedule_at: scheduleAt}));
}
</script>
<template>
    <div
        class="relative min-h-[50px] group"
        :style="style"
    >
        <div
            v-if="!isDisabled && isWorkspaceEditorRole"
            class="absolute mt-xs right-0 mr-sm z-10 opacity-0 group-hover:opacity-100 transition-opacity ease-in-out duration-300">
            <button @click="add" type="button"
                    class="flex items-center text-gray-400 hover:text-primary-500 transition-colors ease-in-out duration-200">
                <span class="mr-xs text-sm">{{ label }}</span>
                <PlusIcon/>
            </button>
        </div>

        <div v-if="posts.length" :class="{'mt-lg': !isDisabled}" class="h-full overflow-hidden">
            <div class="relative p-0.5 md:p-sm overflow-y-auto mixpost-scroll-style h-full">
                <div class="flex flex-wrap space-y-xs w-full">
                    <template v-for="post in posts" :key="post.id">
                        <CalendarPostItem :item="post"/>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

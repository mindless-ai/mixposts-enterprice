<script setup>
import {computed, inject, ref} from "vue";
import {useI18n} from "vue-i18n";
import {parseISO} from "date-fns";
import useDateLocalize from "../../Composables/useDateLocalize";
import {router} from "@inertiajs/vue3";
import {usePage} from "@inertiajs/vue3";
import usePost from "@/Composables/usePost";
import usePostValidator from "@/Composables/usePostValidator";
import useNotifications from "@/Composables/useNotifications";
import useSettings from "@/Composables/useSettings";
import ConfirmationModal from "@/Components/Modal/ConfirmationModal.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import PickTime from "@/Components/Package/PickTime.vue"
import PostTags from "@/Components/Post/PostTags.vue"
import Badge from "@/Components/DataDisplay/Badge.vue";
import ProviderIcon from "@/Components/Account/ProviderIcon.vue";
import CalendarIcon from "@/Icons/Calendar.vue"
import PaperAirplaneIcon from "@/Icons/PaperAirplane.vue"
import XIcon from "@/Icons/X.vue"
import WarningButton from "../Button/WarningButton.vue";
import Forward from "../../Icons/Forward.vue";
import CheckBadgeSolid from "../../Icons/CheckBadgeSolid.vue";
import SuccessButton from "../Button/SuccessButton.vue";
import CheckBadge from "../../Icons/CheckBadge.vue";

const {t: $t} = useI18n()

const props = defineProps({
    form: {
        required: true,
        type: Object
    },
    hasAvailableTimes: {
        type: Boolean,
        default: false,
    }
});

const {postId, editAllowed, needsApproval, userCanApprove} = usePost();
const {validationPassed} = usePostValidator();
const {translatedFormat} = useDateLocalize();

const emit = defineEmits(['submit'])

const workspaceCtx = inject('workspaceCtx');

const timePicker = ref(false);

const {timeFormat, weekStartsOn} = useSettings();

const scheduleTime = computed(() => {
    if (props.form.date && props.form.time) {
        return translatedFormat(new Date(parseISO(props.form.date + ' ' + props.form.time)), `MMM do, ${timeFormat === 24 ? 'kk:mm' : 'h:mmaaa'}`, {
            weekStartsOn: weekStartsOn
        });
    }

    return null;
})

const clearScheduleTime = () => {
    props.form.date = '';
    props.form.time = '';
}

const {notify} = useNotifications();
const isLoading = ref(false);

const canSchedule = computed(() => {
    return (postId.value && props.form.accounts.length) &&
        editAllowed.value &&
        validationPassed.value;
});

const schedule = (postNow = false) => {
    isLoading.value = true;

    axios.post(route('mixpost.posts.schedule', {workspace: workspaceCtx.id, post: postId.value}), {
        postNow
    }).then((response) => {
        const message = `${$t('post.post_scheduled')}\n${response.data.scheduled_at}
        ${response.data.needs_approval ? `<div class="text-sm max-w-xs mt-xs">${$t('post.approval_required')}</div>` : ''}`;

        notify('success', message, {
            name: $t("post.view_in_calendar"),
            href: route('mixpost.calendar', {workspace: workspaceCtx.id, date: props.form.date})
        });

        router.visit(route('mixpost.posts.index', {workspace: workspaceCtx.id}));
    }).catch((error) => {
        handleValidationError(error);
    }).finally(() => {
        isLoading.value = false;
    })
}

const addToQueue = () => {
    isLoading.value = true;

    axios.post(route('mixpost.posts.addToQueue', {
        workspace: workspaceCtx.id,
        post: postId.value
    }), {}).then((response) => {
        const message = `${$t('post.post_scheduled')}\n${response.data.scheduled_at}
        ${response.data.needs_approval ? `<div class="text-sm max-w-xs mt-xs">${$t('post.approval_required')}</div>` : ''}`;

        notify('success', message, {
            name: $t("post.view_in_calendar"),
            href: route('mixpost.calendar', {workspace: workspaceCtx.id, date: response.data.date})
        });

        router.visit(route('mixpost.posts.index', {workspace: workspaceCtx.id}));
    }).catch((error) => {
        handleValidationError(error);
    }).finally(() => {
        isLoading.value = false;
    })
}

const approve = () => {
    isLoading.value = true;

    axios.post(route('mixpost.posts.approve', {workspace: workspaceCtx.id, post: postId.value})).then((response) => {
        notify('success', `${$t('post.post_scheduled')}\n${response.data.scheduled_at}`, {
            name: $t("post.view_in_calendar"),
            href: route('mixpost.calendar', {workspace: workspaceCtx.id, date: props.form.date})
        });

        router.visit(route('mixpost.posts.index', {workspace: workspaceCtx.id}));
    }).catch((error) => {
        handleValidationError(error);
    }).finally(() => {
        isLoading.value = false;
    })
}

const handleValidationError = (error) => {
    if (error.response.status !== 422) {
        notify('error', error);
        return;
    }

    const validationErrors = error.response.data.errors;

    const mustRefreshPage = validationErrors.hasOwnProperty('in_history') || validationErrors.hasOwnProperty('publishing');

    if (!mustRefreshPage) {
        notify('error', error);
    }

    if (mustRefreshPage) {
        router.visit(route('mixpost.posts.edit', {workspace: workspaceCtx.id, post: postId.value}));
    }
}

const confirmationPostNow = ref(false);

const accounts = computed(() => {
    return usePage().props.accounts.filter(account => props.form.accounts.includes(account.id));
})
</script>
<template>
    <div class="w-full flex items-center justify-end bg-stone-500 border-t border-gray-200 z-10">
        <div class="py-4 flex items-center space-x-xs row-px">
            <PostTags :items="form.tags" @update="form.tags = $event"/>

            <div class="flex items-center" role="group">
                <SecondaryButton size="md"
                                 :hiddenTextOnSmallScreen="true"
                                 :class="{ '!normal-case border-r-primary-800 ltr:rounded-r-none rtl:rounded-l-none': scheduleTime, 'ltr:!rounded-r-lg rtl:!rounded-l-lg': !canSchedule }"
                                 @click="timePicker = true">
                    <template #icon>
                        <CalendarIcon/>
                    </template>

                    {{ scheduleTime ? scheduleTime : $t("post.pick_time") }}
                </SecondaryButton>

                <template v-if="scheduleTime && canSchedule">
                    <SecondaryButton size="md" @click="clearScheduleTime" v-tooltip="$t('post.clear_time')"
                                     class="ltr:rounded-l-none ltr:border-l-0 rtl:rounded-r-none rtl:border-r-0 hover:text-red-500 !px-2">
                        <XIcon/>
                    </SecondaryButton>
                </template>

                <PickTime :show="timePicker" :date="form.date" :time="form.time" :isSubmitActive="editAllowed"
                          @close="timePicker = false" @update="form.date = $event.date; form.time = $event.time;"/>
            </div>

            <!-- Display only for users with approval rights-->
            <template v-if="userCanApprove && needsApproval">
                <SuccessButton
                    @click="approve"
                    :hiddenTextOnSmallScreen="true"
                    size="md">
                    <template #icon>
                        <CheckBadge/>
                    </template>

                    {{ $t('post.approve') }}
                </SuccessButton>
            </template>

            <!-- Display only for users with non approval rights-->
            <template v-if="editAllowed && !userCanApprove && !needsApproval && canSchedule && scheduleTime">
                <PrimaryButton @click="schedule()"
                               :hiddenTextOnSmallScreen="true"
                               :disabled="isLoading"
                               :isLoading="isLoading"
                               size="md">
                    <template #icon>
                        <PaperAirplaneIcon/>
                    </template>

                    {{ $t("post.schedule") }}
                </PrimaryButton>
            </template>

            <template v-if="editAllowed && userCanApprove && !needsApproval">
                <PrimaryButton @click="scheduleTime ? schedule() : confirmationPostNow = true"
                               :hiddenTextOnSmallScreen="true"
                               :disabled="!canSchedule || isLoading" :isLoading="isLoading" size="md">
                    <template #icon>
                        <PaperAirplaneIcon/>
                    </template>

                    {{ scheduleTime ? $t("post.schedule") : $t("post.post_now") }}
                </PrimaryButton>
            </template>

            <template v-if="editAllowed && !needsApproval && hasAvailableTimes">
                <WarningButton @click="addToQueue"
                               :hiddenTextOnSmallScreen="true"
                               :disabled="!canSchedule || isLoading" size="md">
                    <template #icon>
                        <Forward/>
                    </template>

                    {{ $t("post.add_to_queue") }}
                </WarningButton>
            </template>

            <template v-if="editAllowed && !userCanApprove">
                <div class="cursor-help" v-tooltip="$t('post.approval_required')">
                    <CheckBadgeSolid class="text-primary-500"/>
                </div>
            </template>
        </div>

        <ConfirmationModal :show="confirmationPostNow" @close="confirmationPostNow = false">
            <template #header>
                {{ $t("post.confirm_publication") }}
            </template>
            <template #body>
                {{ $t("post.now_confirm_publication") }}

                <div class="mt-sm flex flex-wrap items-center gap-xs">
                    <Badge v-for="account in accounts" :key="account.id">
                        <ProviderIcon :provider="account.provider" class="mr-xs"/>
                        {{ account.name }}
                    </Badge>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="confirmationPostNow = false" class="mr-xs">{{ $t("general.cancel") }}
                </SecondaryButton>
                <PrimaryButton :disabled="isLoading" :isLoading="isLoading" @click="schedule(true)"> {{
                        $t("post.post_now")
                    }}
                </PrimaryButton>
            </template>
        </ConfirmationModal>
    </div>
</template>

<script setup>
import {inject} from "vue";
import { useI18n } from "vue-i18n";
import {Link, router} from "@inertiajs/vue3";
import Trash from "../../Icons/Trash.vue";
import DangerButton from "../Button/DangerButton.vue";
import PencilSquare from "../../Icons/PencilSquare.vue";
import PrimaryButton from "../Button/PrimaryButton.vue";
import Flex from "../Layout/Flex.vue";
import SecondaryButton from "../Button/SecondaryButton.vue";
import Eye from "../../Icons/Eye.vue";
import Plus from "../../Icons/Plus.vue";

const { t: $t } = useI18n()

const routePrefix = inject('routePrefix');
const confirmation = inject('confirmation');

const props = defineProps({
    plan: {
        type: Object
    },
    view: {
        type: Boolean,
        default: true
    },
    create: {
        type: Boolean,
        default: true
    },
    edit: {
        type: Boolean,
        default: true
    },
    destroy: {
        type: Boolean,
        default: true
    },
})

const destroy = () => {
    confirmation()
        .title($t('plan.delete_plan'))
        .description($t('plan.confirm_delete_plan'))
        .destructive()
        .onConfirm((dialog) => {
            dialog.isLoading(true);

            router.delete(route(`${routePrefix}.plans.delete`, {plan: props.plan.id}), {
                preserveScroll: true,
                onFinish() {
                    dialog.reset();
                }
            });

        })
        .show();
}
</script>
<template>
    <Flex :responsive="false" class="items-center">
        <template v-if="create">
            <Link :href="route(`${routePrefix}.plans.create`)">
                <PrimaryButton size="sm" :hiddenTextOnSmallScreen="true">
                    <template #icon>
                        <Plus/>
                    </template>
                    {{ $t('general.create') }}
                </PrimaryButton>
            </Link>
        </template>

        <template v-if="view">
            <Link :href="route(`${routePrefix}.plans.view`, {plan: plan.id})">
                <SecondaryButton size="sm">
                    <template #icon>
                        <Eye/>
                    </template>
                    {{ $t('general.view') }}
                </SecondaryButton>
            </Link>
        </template>

        <template v-if="edit">
            <Link :href="route(`${routePrefix}.plans.edit`, {plan: plan.id})">
                <PrimaryButton size="sm" :hiddenTextOnSmallScreen="true">
                    <template #icon>
                        <PencilSquare/>
                    </template>
                    {{ $t('general.edit') }}
                </PrimaryButton>
            </Link>
        </template>

        <template v-if="destroy">
            <DangerButton @click="destroy" size="sm">
                <template #icon>
                    <Trash/>
                </template>
            </DangerButton>
        </template>
    </Flex>
</template>

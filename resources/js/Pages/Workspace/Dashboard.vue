<script setup>
import {computed, inject, onMounted, ref, watch} from "vue";
import {Head, Link} from '@inertiajs/vue3';
import {useI18n} from "vue-i18n";
import NProgress from 'nprogress'
import {find} from "lodash";
import useNotifications from "@/Composables/useNotifications";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import Account from "@/Components/Account/Account.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Tabs from "@/Components/Navigation/Tabs.vue"
import Tab from "@/Components/Navigation/Tab.vue"
import TwitterReports from "@/Components/Report/TwitterReports.vue"
import FacebookPageReports from "@/Components/Report/FacebookPageReports.vue"
import FacebookGroupReports from "@/Components/Report/FacebookGroupReports.vue"
import InstagramReports from "@/Components/Report/InstagramReports.vue"
import ThreadsReports from "@/Components/Report/ThreadsReports.vue"
import MastodonReports from "@/Components/Report/MastodonReports.vue"
import PinterestReports from "@/Components/Report/PinterestReports.vue"
import LinkedinReports from "@/Components/Report/LinkedinReports.vue"
import LinkedinPageReports from "@/Components/Report/LinkedinPageReports.vue"
import TikTokReports from "@/Components/Report/TikTokReports.vue"
import YoutubeReports from "@/Components/Report/YoutubeReports.vue"
import BlueskyReports from "@/Components/Report/BlueskyReports.vue"
import useWorkspace from "@/vendor/mixpost/Composables/useWorkspace.js";

const {t: $t} = useI18n()

const props = defineProps({
    accounts: {
        required: true,
        type: Array,
    }
})

const workspaceCtx = inject('workspaceCtx');

const {notify} = useNotifications();
const {isWorkspaceEditorRole} = useWorkspace();

const isLoading = ref(false);
const data = ref({
    metrics: {},
    audience: {}
});

const selectAccount = (account) => {
    workspaceCtx.dashboard_filter.account_id = account.id;
}

const isAccountSelected = (account) => {
    return workspaceCtx.dashboard_filter.account_id === account.id;
}

const selectPeriod = (value) => {
    workspaceCtx.dashboard_filter.period = value;
}

const isPeriodSelected = (value) => {
    return workspaceCtx.dashboard_filter.period === value;
}

const fetch = () => {
    isLoading.value = true;
    NProgress.start();

    axios.get(route('mixpost.reports', {workspace: workspaceCtx.id}), {
        params: workspaceCtx.dashboard_filter
    }).then(function (response) {
        data.value = response.data;
    }).catch(() => {
        notify('error', $t('dashboard.error_retrieving_analytics'));
    }).finally(() => {
        isLoading.value = false;
        NProgress.done();
    });
}

const providers = {
    'twitter': TwitterReports,
    'facebook_page': FacebookPageReports,
    'facebook_group': FacebookGroupReports,
    'instagram': InstagramReports,
    'threads': ThreadsReports,
    'mastodon': MastodonReports,
    'pinterest': PinterestReports,
    'linkedin': LinkedinReports,
    'linkedin_page': LinkedinPageReports,
    'tiktok': TikTokReports,
    'youtube': YoutubeReports,
    'bluesky': BlueskyReports,
};

const component = computed(() => {
    const account = find(props.accounts, {id: workspaceCtx.dashboard_filter.account_id});

    if (account === undefined) {
        return;
    }

    return providers[account.provider];
});

// Function to open URL in new tab without Inertia.js interference
const openInNewTab = (url) => {
    const newWindow = window.open(url, '_blank');
    if (newWindow) newWindow.opener = null; // Prevents the new page from being able to access the window.opener property
};

onMounted(() => {
    if (!props.accounts.length) {
        return null;
    }

    if (!workspaceCtx.dashboard_filter.account_id) {
        selectAccount(props.accounts[0]);
        return null;
    }

    fetch();
})

watch(workspaceCtx.dashboard_filter, () => {
    fetch()
});
</script>
<template>
    <Head :title="$t('dashboard.dashboard')"/>

    <div class="row-py">
        <PageHeader :title="$t('dashboard.dashboard')">
            <div>
                <Tabs v-if="accounts.length">
                    <Tab @click="selectPeriod('7_days')" :active="isPeriodSelected('7_days')">7 {{
                            $t("dashboard.days")
                        }}
                    </Tab>
                    <Tab @click="selectPeriod('30_days')" :active="isPeriodSelected('30_days')">30
                        {{ $t("dashboard.days") }}
                    </Tab>
                    <Tab @click="selectPeriod('90_days')" :active="isPeriodSelected('90_days')">90
                        {{ $t("dashboard.days") }}
                    </Tab>
                </Tabs>
            </div>
        </PageHeader>

        <!-- External Links Section -->
        <div class="row-px mb-xl">
            <div class="flex flex-wrap gap-4">
                <button 
                    @click="openInNewTab('https://www.google.com')" 
                    class="flex-1 bg-blue-50 hover:bg-blue-100 rounded-xl p-4 flex items-center justify-between shadow-sm transition-all">
                    <div class="flex flex-col">
                        <span class="font-medium text-blue-800 text-lg">Search Analytics</span>
                        <span class="text-blue-600 text-sm">View your Google search performance</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </button>
                
                <button 
                    @click="openInNewTab('https://analytics.twitter.com')" 
                    class="flex-1 bg-emerald-50 hover:bg-emerald-100 rounded-xl p-4 flex items-center justify-between shadow-sm transition-all">
                    <div class="flex flex-col">
                        <span class="font-medium text-emerald-800 text-lg">Social Analytics</span>
                        <span class="text-emerald-600 text-sm">Check your Twitter engagement metrics</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="row-px flex items-center">
            <div class="w-full">
                <div v-if="accounts.length" class="flex flex-wrap items-center gap-sm">
                    <template v-for="account in accounts" :key="account.id">
                        <button @click="selectAccount(account)" type="button">
                            <Account
                                :provider="account.provider"
                                :name="account.name"
                                :active="isAccountSelected(account)"
                                :img-url="account.image"
                                v-tooltip="account.name"
                            />
                        </button>
                    </template>
                </div>
                <div v-else>
                    <template v-if="isWorkspaceEditorRole">
                        <p class="mb-xs">{{ $t("account.add_social_account") }}</p>
                        <Link :href="route('mixpost.accounts.index', {workspace: workspaceCtx.id})">
                            <PrimaryButton>{{ $t("account.add_account", 2) }}</PrimaryButton>
                        </Link>
                    </template>
                </div>
            </div>
        </div>

        <component :is="component" :data="data" :isLoading="isLoading"/>
    </div>
</template>

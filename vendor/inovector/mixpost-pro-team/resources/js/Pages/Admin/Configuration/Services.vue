<script setup>
import {ref, defineAsyncComponent} from "vue";
import {Head, useForm} from '@inertiajs/vue3';
import { useI18n } from "vue-i18n";
import AdminLayout from "@/Layouts/Admin.vue";
import PageHeader from "@/Components/DataDisplay/PageHeader.vue";
import Tabs from "@/Components/Navigation/Tabs.vue"
import Tab from "@/Components/Navigation/Tab.vue"
import GoogleIcon from "@/Icons/Google.vue";
import UnsplashIcon from "@/Icons/Unsplash.vue";
import ProviderIcon from "../../../Components/Account/ProviderIcon.vue";
import OpenAI from "../../../Icons/OpenAI.vue";
import Tenor from "../../../Icons/Tenor.vue";

const FacebookServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/FacebookServiceForm.vue"));
const ThreadsServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/ThreadsServiceForm.vue"));
const BlueskyServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/BlueskyServiceForm.vue"));
const GoogleServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/GoogleServiceForm.vue"));
const PinterestServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/PinterestServiceForm.vue"));
const LinkedInServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/LinkedInServiceForm.vue"));
const TikTokServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/TikTokServiceForm.vue"));
const TwitterServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/TwitterServiceForm.vue"));
const UnsplashServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/UnsplashServiceForm.vue"));
const TenorServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/TenorServiceForm.vue"));
const OpenAIServiceForm = defineAsyncComponent(() => import("@/Components/ServiceForm/OpenAIServiceForm.vue"));

defineOptions({layout: AdminLayout});

const { t: $t } = useI18n();

const props = defineProps(['services'])

const form = useForm(props.services);

const tab = ref('facebook');
</script>
<template>
    <Head :title="$t('service.third_party_services')"/>

    <div class="row-py w-full mx-auto">
        <PageHeader :title="$t('service.third_party_services')">
            <template #description>
                {{ $t("service.third_party_services_desc") }}
            </template>
        </PageHeader>

        <div class="w-full row-px mb-lg">
            <Tabs>
                <Tab @click="tab = 'facebook'" :active="tab === 'facebook'">
                    <template #icon>
                        <ProviderIcon provider="facebook"/>
                    </template>

                    Facebook
                </Tab>

                <Tab @click="tab = 'threads'" :active="tab === 'threads'">
                    <template #icon>
                        <ProviderIcon provider="threads"/>
                    </template>

                    Threads
                </Tab>

                <Tab @click="tab = 'bluesky'" :active="tab === 'bluesky'">
                    <template #icon>
                        <ProviderIcon provider="bluesky"/>
                    </template>

                    Bluesky
                </Tab>

                <Tab @click="tab = 'google'" :active="tab === 'google'">
                    <template #icon>
                        <GoogleIcon class="text-google"/>
                    </template>
                    Google
                </Tab>

                <Tab @click="tab = 'pinterest'" :active="tab === 'pinterest'">
                    <template #icon>
                        <ProviderIcon provider="pinterest"/>
                    </template>
                    Pinterest
                </Tab>

                <Tab @click="tab = 'linkedin'" :active="tab === 'linkedin'">
                    <template #icon>
                        <ProviderIcon provider="linkedin"/>
                    </template>
                    LinkedIn
                </Tab>

                <Tab @click="tab = 'tiktok'" :active="tab === 'tiktok'">
                    <template #icon>
                        <ProviderIcon provider="tiktok"/>
                    </template>
                    TikTok
                </Tab>

                <Tab @click="tab = 'twitter'" :active="tab === 'twitter'">
                    <template #icon>
                        <ProviderIcon provider="twitter"/>
                    </template>
                    X
                </Tab>

                <Tab @click="tab = 'unsplash'" :active="tab === 'unsplash'">
                    <template #icon>
                        <UnsplashIcon class="text-black"/>
                    </template>
                    Unsplash
                </Tab>

                <Tab @click="tab = 'tenor'" :active="tab === 'tenor'">
                    <template #icon>
                        <Tenor/>
                    </template>
                    Tenor
                </Tab>

                <Tab @click="tab = 'openai'" :active="tab === 'openai'">
                    <template #icon>
                        <OpenAI class="text-openai"/>
                    </template>
                    OpenAI
                </Tab>
            </Tabs>
        </div>

        <div class="row-px">
            <template v-if="tab === 'facebook'">
                <FacebookServiceForm :form="form.facebook"/>
            </template>

            <template v-if="tab === 'threads'">
                <ThreadsServiceForm :form="form.threads"/>
            </template>

            <template v-if="tab === 'bluesky'">
                <BlueskyServiceForm :form="form.bluesky"/>
            </template>

            <template v-if="tab === 'google'">
                <GoogleServiceForm :form="form.google"/>
            </template>

            <template v-if="tab === 'pinterest'">
                <PinterestServiceForm :form="form.pinterest"/>
            </template>

            <template v-if="tab === 'twitter'">
                <TwitterServiceForm :form="form.twitter"/>
            </template>

            <template v-if="tab === 'linkedin'">
                <LinkedInServiceForm :form="form.linkedin"/>
            </template>

            <template v-if="tab === 'tiktok'">
                <TikTokServiceForm :form="form.tiktok"/>
            </template>

            <template v-if="tab === 'unsplash'">
                <UnsplashServiceForm :form="form.unsplash"/>
            </template>

            <template v-if="tab === 'tenor'">
                <TenorServiceForm :form="form.tenor"/>
            </template>

            <template v-if="tab === 'openai'">
                <OpenAIServiceForm :form="form.openai"/>
            </template>
        </div>
    </div>
</template>

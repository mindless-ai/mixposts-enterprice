<script setup>
import Panel from "@/Components/Surface/Panel.vue";
import {computed} from "vue";
import ChartTrend from "../Chart/ChartTrend.vue";

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: true,
    }
});

const getAudienceData = (value) => {
    return props.data.audience.hasOwnProperty(value) ? props.data.audience[value] : []
}

const chartData = computed(() => {
    return {
        labels: getAudienceData('labels'),
        aggregates: getAudienceData('values'),
    }
})
</script>
<template>
    <div class="row-px mt-2xl">
        <Panel>
            <template #title>{{ $t('report.audience') }}</template>
            <template #description>{{ $t('report.followers_per_day') }}</template>
            <ChartTrend :label="$t('report.followers')" :labels="chartData.labels" :aggregates="chartData.aggregates"/>
        </Panel>
    </div>
</template>

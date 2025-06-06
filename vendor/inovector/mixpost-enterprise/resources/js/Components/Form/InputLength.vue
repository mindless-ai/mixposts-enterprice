<script setup>
import {nextTick, onMounted, ref, getCurrentInstance} from 'vue';

const props = defineProps({
    modelValue: {
        required: true,
    },
    error: {
        required: false,
    },
    min: {
        type: Number,
        default: 0,
    },
    maxLimit: {
        type: Number,
        default: 7,
    },
    step: {
        type: String,
        default: 'any'
    }
});

const emits = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        nextTick(() => {
            input.value.focus();
        })
    }
});

const instance = getCurrentInstance();

const updateValue = (event) => {
    const value = event.target.value;

    if (String(value).length <= props.maxLimit) {
        emits('update:modelValue', value)
    }

    if (value < props.min) {
        emits('update:modelValue', 0)
    }

    if (value.substring(0, 1) === "0") {
        const zeroRemoved = value.replace(/^0+/g, "");
        emits('update:modelValue', zeroRemoved ? zeroRemoved : 0)
    }

    instance?.proxy?.$forceUpdate();
}
</script>

<template>
    <input :value="modelValue"
           @input="updateValue"
           :step="step"
           type="number"
           ref="input"
           :class="{'border-stone-600': !error, 'border-red-600': error}"
           class="w-full rounded-md focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 outline-none transition-colors ease-in-out duration-200">
</template>

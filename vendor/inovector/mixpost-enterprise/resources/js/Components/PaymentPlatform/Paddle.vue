<script setup>
import Input from "../Form/Input.vue";
import Textarea from "../Form/Textarea.vue";
import ReadDocHelp from "../Util/ReadDocHelp.vue";
import Select from "../Form/Select.vue";
import VerticalGroup from "../Layout/VerticalGroup.vue";
import InputHidden from "../Form/InputHidden.vue";
import Label from "../Form/Label.vue";

defineProps({
    form: {
        type: Object,
        required: true,
    }
})
</script>

<template>
    <div>
        <ReadDocHelp :href="`${$page.props.mixpost.docs_link}/services/payment/paddle`"/>

        <VerticalGroup class="mt-lg">
            <template #title><label for="vendor_id">Vendor ID</label></template>
            <Input type="text" v-model="form.credentials.vendor_id" id="vendor_id" autocomplete="off"/>
        </VerticalGroup>

        <VerticalGroup class="mt-lg">
            <template #title><label for="vendor_auth_code">Vendor Auth Code</label></template>
            <InputHidden v-model="form.credentials.vendor_auth_code" id="vendor_auth_code" autocomplete="off"/>
        </VerticalGroup>

        <VerticalGroup class="mt-lg">
            <template #title><label for="public_key">Public Key</label></template>
            <Textarea v-model="form.credentials.public_key" id="public_key" autocomplete="off"/>
        </VerticalGroup>

        <VerticalGroup class="mt-lg">
            <template #title><label for="sandbox">Sandbox</label></template>
            <Select v-model="form.options.sandbox" id="sandbox">
                <option :value="false">{{ $t('general.no') }}</option>
                <option :value="true">{{ $t('general.yes') }}</option>
            </Select>
        </VerticalGroup>
    </div>
</template>

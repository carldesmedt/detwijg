<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import OdrMgmDetail from '@/ComponentsOdrTwijg/OdrMgmDetail.vue';

const props = defineProps({
    event: Object,
    shifts: Array,
    subscriptions: Array,
    subscription_param: Object,
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <OdrMgmDetail :event="event" :shifts="shifts" :subscriptions="subscriptions" :param="subscription_param" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
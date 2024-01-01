<script setup>
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import Block from '@/ComponentsOdrTwijg/MgmIndexBlock.vue';

const props = defineProps({
    events: Array,
})

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-groen-twijg">
                Registratie inschrijvingen - Dashboard
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">
                
            </p>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-2 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            
                <Block v-for="event in events" class="border-8" :event ="event.data" :subscription_required="event.subscription_required" :shifts="event.shifts" :online="Date.parse(event.data.online)<Date.now()&&Date.parse(event.data.offline)>Date.now() ? true : false" />
            
            
            

            

            

            
        </div>
    </div>
</template>

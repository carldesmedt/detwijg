<script setup>

const props = defineProps({
    online: Boolean,
    subscription_required: Boolean,
    event: Object,
    shifts: Array,
})


</script>
<template>
    <a :href="route('mgmdetail', event.slug)" class="scale-100 p-6 bg-gray-300 bg-opacity-25  from-gray-700/50 via-transparent  rounded-lg shadow-2xl shadow-gray-500/20  flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="ms-3 text-2xl font-semibold text-bruin-twijg">
                    <div >{{ event.name }}   <span v-if="online" class="text-xs text-green-500">Online</span><span v-else class="text-xs text-red-500">Offline</span></div>
                </h2>
            </div>
            <div class="text-sm">
                <span class="font-bold text-groen-twijg">Datum: </span><span class="text-xs">{{ event.startdate }} <span v-if="event.enddate"> - {{ event.enddate }}</span></span>
            </div>
            <div class="text-sm">
                <span class="font-bold text-groen-twijg">Tijdstip: </span>
                <span v-for="shift in shifts" class="text-xs">
                    {{ shift.start }} - {{ shift.end }} <br>
                </span>
            </div>
            <div class="mt-4 text-gray-500 text-sm leading-relaxed" v-html="event.description"></div>
            
            <div class="mt-4 pt-4 grid grid-cols2 border-t">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Inschrijven verplicht: </span> <span v-if="subscription_required">Ja</span><span v-else>Nee</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Max aantal inschrijvingen: </span>
                            <span v-for="shift in shifts">
                                <span v-if="shifts.length > 1">{{ shift.start }} - {{ shift.end }} : </span>{{ shift.max_subscriptions }}
                            </span>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </a>
</template>
<script setup>

defineProps({
    event: Object
});
</script>

<template>
    <a  :href="'/'+event.slug" class="scale-100 p-6 bg-white  from-gray-700/50 via-transparent  rounded-lg shadow-2xl shadow-gray-500/20  flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div>
            <div class="h-16 w-16 bg-red-50 flex items-center justify-center rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-bruin-twijg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>

            <h2 class="my-6 text-xl font-semibold text-bruin-twijg" >{{ event.name }}</h2>
            <div  v-if="event.subscription_required">
                <div class="font-bold text-groen-twijg leading-relaxed">Inschrijving verplicht</div>
            </div>
            <div class="mt-4 text-groen-twijg  leading-relaxed">Datum: 
                <span v-if="event.end_date" class=" text-sm text-gray-600  ">{{ event.start_date }} - {{ event.end_date }}</span>
                <span v-else class=" text-sm text-gray-600 ">{{ event.start_date }} </span>
            </div>
            <div v-if="event.location" class="text-groen-twijg  leading-relaxed">Locatie: <span class=" text-sm text-gray-600 "> {{ event.location }}</span> </div>
            
            <p class="mt-4 text-gray-500  text-sm leading-relaxed">
                <div v-html="event.description"></div>
            </p>
            
            
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-bruin w-6 h-6 mx-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
        </svg>
    </a>
</template>
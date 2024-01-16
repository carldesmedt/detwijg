<script setup>
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import OdrBanner from '@/ComponentsOdrTwijg/OdrBanner.vue';


const props = defineProps({
    event: Object,
    subscription: Object,
    free: Number,
})

</script>

<template>
    <Head title="Ouderraad De Twijg" />
    <OdrBanner />
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-bg-twijg selection:bg-bruin-twijg selection:text-white">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-center">
                <ApplicationLogo />
            </div>
            <div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                            <h1 class="mt-2 text-center text-2xl font-bold text-groen-twijg">
                                Inschrijving {{ event.name }} geregistreerd
                            </h1>
                            

                        </div>

                        <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8 text-sm text-gray-700">
                            <p class="mb-2">Beste {{ subscription.name}}, </p>
                            <p class="mb-2"> Wij danken je voor jouw interesse voor {{ event.name }} . 
                                <br>De plaatsen zijn echter beperkt en intussen is de {{ event.name }} volzet</p>
                            <p class="mb-2"> Jouw inschrijving werd genoteerd op de reservelijst. Mocht er alsnog een plaats vrijkomen zulen wij jou contacteren. 
                                <br>Hieronder vind je een opsomming van jouw gegevens.</p>

                            <ul class="mb-2">
                                <li>Naam: <span>{{subscription.name}}</span></li>
                                <li>Ploegnaam: <span>{{subscription.team}}</span></li>
                                <li>E-mail: <span>{{subscription.email}}</span></li>                                
                            </ul>
                            <p>mvg,<br>
                            Ouderraad De Twijg</p>
                        </div>
                        <div class="text-gray-500 text-xs text-center my-8">
                            <p>Deze info werd u ook per mail toegestuurd via {{subscription.email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import OdrBanner from '@/ComponentsOdrTwijg/OdrBanner.vue';


const props = defineProps({
    event: Object,
    subscription: Object,
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
                            <p class="mb-2"> Wij danken u voor uw inschrijving voor {{ event.name }} . 
                                <br>Wij hebben alvast een plaats voor u gereserveerd.</p>
                            <p class="mb-2"> Om uw inschrijving definitief te maken vragen wij u om het inschrijvingsgeld over te maken op onze rekening. 
                                <br>Detail van uw reservatie en betalingsgegevens vindt u hieronder.</p>

                            <ul class="mb-2">
                                <li>Naam: <span class="font-bold">{{subscription.name}}</span></li>
                                <li>Ploegnaam: <span class="font-bold">{{subscription.team}}</span></li>
                                <li>E-mail: <span class="font-bold">{{subscription.email}}</span></li>
                                <li>Bedrag inschrijving: <span class="font-bold">{{subscription.fee}}</span> euro</li>
                                <li>Rekeningnummer: <span class="font-bold">BE29 7340 4090 0764</span></li>
                                <li>Referentie: <span class="font-bold">{{subscription.reference}}</span></li>
                                
                            </ul>
                            <p class="mb-2">Wij kijken uit naar uw deelname</p>
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
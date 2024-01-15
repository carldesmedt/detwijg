<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import OdrBanner from '@/ComponentsOdrTwijg/OdrBanner.vue';
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    event: Object,
    subscription: Object,
    shifts: Object,
    location: String,
});
const subscriptionForm = useForm({
    _method: 'POST',
    shift_id: null,
    name: null,
    email: null,
    address: null,
    phone: null,
    contact: null,
    class: null,
    team: null,
    fee: null,
})

const create_subscription = () => {
    if (subscriptionForm.shift_id == null && props.shifts.length == 1){
        subscriptionForm.shift_id = props.shifts[0].id;
    }
    subscriptionForm.fee = props.subscription.fee;
    subscriptionForm.post(route('subscription.store'), {
        preserveScroll: true,
    });
}
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
                            <h1 class="lg:mb-16 sm:mb-4 flex justify-center mt-8 text-5xl font-black text-bruin-twijg">
                                {{ event.name }}
                            </h1>
                            <div v-if="subscription.required">
                                <div  class="font-bold text-groen-twijg  leading-relaxed">
                                    Inschrijven verplicht
                                </div>
                                <div v-if="subscription.fee" class="text-gray-600  leading-relaxed text-sm">
                                    Inschrijvingsbedrag: {{ subscription.fee }} euro
                                </div>
                                <div v-if="shifts.length > 1">
                                    <div v-for="(shift, index) in shifts" class="text-sm text-gray-600">Vrije plaatsen: {{ shift.free_space }} ({{ shift.start }} - {{ shift.end }})</div>
                                </div>
                                <div v-else-if="shifts.length == 1">
                                    <div class="font-normal text-sm text-gray-600">Vrije plaatsen: <span v-if="shifts[0].free_space > 0">{{ shifts[0].free_space }}</span><span v-else class="text-red-500">volzet</span></div>
                                </div>



                            </div>
                            <div class="mt-4 text-groen-twijg  leading-relaxed font-bold">Datum: 
                                <span v-if="event.date_end" class=" font-normal text-sm text-gray-600">Van {{ event.date_start }} tot {{ event.date_end }}</span>
                                <span v-else class=" text-sm  font-normal text-gray-600">{{ event.date_start }} </span>
                            </div>
                            <div v-if="shifts.length > 1">
                                <div v-for="(shift, index) in shifts" class="text-sm text-gray-600">{{ shift.start }} - {{ shift.end }}</div>
                            </div>
                            <div v-else-if="shifts.length == 1">
                                <div class="text-groen-twijg leading-relaxed font-bold">Tijdstip: <span class="font-normal text-sm text-gray-600">{{ shifts[0].start }} - {{ shifts[0].end }}</span></div>
                            </div>
                            <div v-if="location" class="mt-4 text-groen-twijg  leading-relaxed font-bold">
                                Locatie: <span class=" text-sm font-normal text-gray-600"> {{ location }}</span>
                            </div>
                            <p class="mt-6 text-gray-500 leading-relaxed">
                                <div v-html="event.description"></div> 
                            </p>
                            <p v-if="shifts.free_space == 0" class="mt-6 text-gray-500 leading-relaxed text-sm">
                                <span class="font-bold text-red-500">Let op: </span>De plaatsen zijn beperkt. Er zijn momenteel geen vrije plaatsen.<br>
                                Je kan wel nog inschrijven. Wij contacteren je mocht er alsnog een plaats vrijkomen. 
                            </p>
                            <p v-if="subscription.fee" class="mt-6 text-gray-500 leading-relaxed text-sm">
                                Dit evenement omvat een betalende inschrijving.<br>
                                Na het invullen van het inschrijvingsformulier reserveert u een plaats en ontvangt u een e-mail met de betalingsgegevens. Zodra wij uw betaling ontvangen hebben wordt de plaats definitief toegekend. 
                            </p>
                        </div>
                        <div v-if="subscription.required" class="bg-gray-200 bg-opacity-25 lg:p-8 lg:px-32">
                            <form @submit.prevent="create_subscription">
                                
                                <div class="mb-4 text-center text-2xl text-groen-twijg font-bold">Inschrijvingsformulier voor {{ event.name }}</div>
                                
                                <div class="px-4 lg:px-32 py-8 border-2 rounded-lg">
                                    <div v-if="shifts.lengt > 1" class="grid grid-cols-2">
                                        <InputLabel  value="Shift" class=" text-groen-twijg font-bold"/>
                                        <div>
                                            <div v-for="(shift, index) in shifts">
                                            <input type="radio" :id="'shift'+shift.id" v-model="subscriptionForm.shift_id" :value="shift.id" class="appearance-none accent-groen-twijg  checked:bg-groen-twijg focus:bg-groen-twijg " required><span class="text-sm text-gray-500 ml-2">{{ shift.start }} - {{ shift.end }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="subscription.param.subName" class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="name" value="Naam" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="name"
                                            v-model="subscriptionForm.name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subAddress"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="address" value="Adres" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="address"
                                            v-model="subscriptionForm.address"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subPhone"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="phone" value="Telefoon" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="phone"
                                            v-model="subscriptionForm.phone"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subEmail"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="email" value="Email" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="email"
                                            v-model="subscriptionForm.email"
                                            type="email"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subContact"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="contact" value="Contact binnen de school" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="contact"
                                            v-model="subscriptionForm.contact"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subClass"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="class" value="Klas" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="class"
                                            v-model="subscriptionForm.class"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div v-if="subscription.param.subTeam"  class="lg:grid lg:grid-cols-2">
                                        <InputLabel for="class" value="Ploegnaam" class=" text-groen-twijg font-bold"/>
                                        <TextInput
                                            id="class"
                                            v-model="subscriptionForm.team"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                    </div>
                                    <div class="mt-8 text-center lg:text-right">
                                        <button type="submit" class="font-bold bg-groen-twijg text-white px-4 py-2 rounded-full" >
                                            INSCHRIJVEN
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
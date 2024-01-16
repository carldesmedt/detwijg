<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import OdrMgmDetail from '@/ComponentsOdrTwijg/OdrMgmDetail.vue';
import DialogModal from '@/Components/DialogModal.vue';

const props = defineProps({
    event: Object,
    shifts: Array,
    subscriptions: Array,
    subscription_param: Object,
});

const modal = ref({
    pay:false
});
const payform = useForm({
    paidsubs: [],
});
const sendPay = () => {
    
    payform.post(route('subscription.paid'),{
        onSuccess: () => payform.reset(),
        onFinish: () => modal.value.pay = false,
    });
    
    
}
const subs = ref(props.subscriptions);
let search = ref('');
const query = ref(subs.value.filter((sub) => sub.reference));
const filtered = computed(() => {
    return query.value.filter((sub) => sub.status!= 'paid' && (sub.reference.startsWith(search.value)|| sub.name.startsWith(search.value)))
});

const paidsubs = ref([]);
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
                    
                </div>
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <ApplicationLogo class="block h-12 w-auto" />
                    <h1 class="mt-8 text-2xl font-medium text-gray-900">
                        Instellingen en details
                    </h1>
                    <div class="mt-6 text-gray-500 leading-relaxed">
                        <div class="grid md:grid-cols-3 gap-32">
                            <div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Naam event:</span>
                                    <span>{{ event.name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Datum<span v-if="event.date_end"> van</span>:</span>
                                    <span>{{ event.date_start }}</span>
                                </div>
                                <div v-if="event.date_end" class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Datum tot:</span>
                                    <span>{{ event.date_end }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Online van:</span>
                                    <span>{{ event.date_online }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Online tot:</span>
                                    <span>{{ event.date_offline }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Inschrijven:</span>
                                    <span v-if="shifts[0].subscription_required">verplicht</span><span v-else>nvt</span>
                                </div>
                                <div v-if="shifts[0].subscription_fee" class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Bedrag:</span>
                                    <span>{{ shifts[0].subscription_fee }} euro</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Maximum aantal:</span>
                                    <span>{{ shifts[0].subscription_max }} teams</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Inschrijven van:</span>
                                    <span>{{ shifts[0].subscription_start }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Inschrijven tot:</span>
                                    <span>{{ shifts[0].subscription_end }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Gereserveerd:</span>
                                    <span>{{ subscriptions.filter((subscription)=>subscription['status']== 'reserved').length}}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Wachtlijst:</span>
                                    <span>{{ subscriptions.filter((subscription)=>subscription['status']== 'on hold').length}}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Betaald:</span>
                                    <span>{{ subscriptions.filter((subscription)=>subscription['status']== 'paid').length}}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Geannuleerd:</span>
                                    <span>{{ subscriptions.filter((subscription)=>subscription['status']== 'canceld').length}}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-bold text-groen-twijg">Totaal:</span>
                                    <span>{{ subscriptions.length}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button @click.prevent="modal.pay=true" class="rounded-full bg-groen-twijg text-white p-4">Betalingen registreren</button>
                    <div class="grid grid-cols-7 font-bold text-groen-twijg text-center border-b my-8">
                        <div>Team</div>
                        <div>Kapitein</div>
                        <div>Email</div>
                        <div>Telefoon</div>
                        <div>Bedrag</div>
                        <div>Referentie</div>
                        <div>Status</div>
                    </div>
                    <div class="mt-4">
                        <p v-for="detail in subs" class="text-center text-sm grid grid-cols-7 gap-2">
                            <div v-if="subscription_param.subTeam">{{ detail.team }}</div>
                            <div v-if="subscription_param.subName">{{ detail.name }}</div>
                            <div v-if="subscription_param.subEmail">{{ detail.email }}</div>
                            <div v-if="subscription_param.subAddress">{{ detail.address }}</div>
                            <div v-if="subscription_param.subPhone">{{ detail.phone }}</div>
                            <div v-if="subscription_param.subContact">{{ detail.referenced_contact }}</div>
                            <div v-if="subscription_param.subClass">{{ detail.class }}</div>
                            <div>{{ detail.fee }} euro</div>
                            <div>{{ detail.reference }}</div>
                            <div>{{ detail.status }}</div> 
                            
                        </p>
                    </div>   
                </div>
            </div>
        </div>
    </AppLayout>
    <DialogModal :show="modal.pay" @close="modal.pay = false" >
        <template #title>
                <div class="text-2xl text-groen-twijg">Betaling registreren</div>
        </template>
        <template #content>
            <div class="flex items-center mb-4">
                <div class="font-bold text-groen-twijg mr-8 text-lg">filter data:</div>
                <TextInput
                id="query"
                v-model="search"
                type="text"
                class="mt-1 block w-1/2" 
            />
            </div>
            <div class="grid grid-cols-4 text-base text-groen-twijg border-b-2 text-center">
                <div>Naam</div>
                <div>Team</div>
                <div>Referentie</div>
                <div>Betaald</div>
            </div>
            <div v-for="result in filtered">
                <div class="grid grid-cols-4 text-center">
                    <div>{{ result.name }}</div>
                    <div>{{ result.team }} </div>
                    <div>{{ result.reference }}</div>
                    <div><input type="checkbox" :value="result.id" v-model="payform.paidsubs" ></div>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="align-right">
                <PrimaryButton @click.prevent="sendPay">Save</PrimaryButton>
            </div>
        </template>
    </DialogModal>
</template>